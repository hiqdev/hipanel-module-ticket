<?php
/**
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\ticket\controllers;

use hipanel\actions\Action;
use hipanel\actions\IndexAction;
use hipanel\actions\PrepareAjaxViewAction;
use hipanel\actions\PrepareBulkAction;
use hipanel\actions\ProxyAction;
use hipanel\actions\RedirectAction;
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartPerformAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\filters\EasyAccessControl;
use hipanel\modules\client\models\Client;
use hipanel\modules\client\models\stub\ClientRelationFreeStub;
use hipanel\modules\server\models\Server;
use hipanel\modules\ticket\models\Thread;
use hipanel\modules\ticket\models\ThreadSearch;
use hipanel\modules\ticket\models\TicketSettings;
use hiqdev\hiart\ResponseErrorException;
use Yii;
use yii\base\Event;
use yii\filters\PageCache;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class TicketController.
 */
class TicketController extends \hipanel\base\CrudController
{
    /**
     * Used to create newModel.
     * @return string
     */
    public static function modelClassName()
    {
        return Thread::class;
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => PageCache::class,
                'only' => ['templates'],
                'duration' => 7200, // 2h
                'variations' => [
                    Yii::$app->user->getId(),
                ],
            ],
            [
                'class' => EasyAccessControl::class,
                'actions' => [
                    'create'    => 'ticket.create',
                    'answer'    => 'ticket.answer',
                    'delete'    => 'ticket.delete',
                    '*'         => 'ticket.read',
                ],
            ],
        ]);
    }

    public function actions()
    {
        return array_merge(parent::actions(), [
            'index' => [
                'class' => IndexAction::class,
                'data' => $this->prepareRefs(),
            ],
            'view' => [
                'class' => ViewAction::class,
                'findOptions' => $this->getSearchOptions(),
                'on beforeSave' => function (Event $event) {
                    /** @var PrepareBulkAction $action */
                    $action = $event->sender;
                    $dataProvider = $action->getDataProvider();
                    $dataProvider->query->joinWith('answers');
                },
                'data' => function ($action) {
                    $ticket = $action->model;

                    $attributes = [
                        'id' => $ticket->recipient_id,
                        'login' => $ticket->recipient,
                        'seller' => $ticket->recipient_seller,
                        'seller_id' => $ticket->recipient_seller_id,
                    ];

                    $isAnonymTicket = $ticket->recipient === 'anonym';
                    if ($isAnonymTicket) {
                        $attributes['seller'] = $ticket->anonym_seller;
                    }

                    $client = new ClientRelationFreeStub($attributes);

                    if ($isAnonymTicket) {
                        $client->email = $ticket->anonym_email;
                        $client->name = $ticket->anonym_name;
                    }

                    return array_merge(compact('client'), $this->prepareRefs());
                },
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
            'answer' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:ticket', 'Ticket changed'),
                'POST html' => [
                    'save' => true,
                    'success' => [
                        'class' => RedirectAction::class,
                        'url'   => function ($action) {
                            return $action->collection->count() > 1
                                ? $action->controller->getSearchUrl()
                                : $action->controller->getActionUrl('view', ['id' => $action->collection->first->id]);
                        },
                    ],
                    'error' => [
                        'class' => RedirectAction::class,
                    ]
                ],
            ],
            'create' => [
                'class' => SmartCreateAction::class,
                'success' => Yii::t('hipanel:ticket', 'Ticket posted'),
                'data' => function () {
                    return $this->prepareRefs();
                },
            ],
            'delete' => [
                'class' => SmartPerformAction::class,
                'success' => Yii::t('hipanel:ticket', 'Ticket deleted'),
            ],
            'subscribe' => [
                'class' => SmartPerformAction::class,
                'scenario' => 'answer',
                'success' => Yii::t('hipanel:ticket', 'Subscribed'),
                'on beforeSave' => function (Event $event) {
                    /** @var Action $action */
                    $action = $event->sender;
                    foreach ($action->collection->models as $model) {
                        $model->{$this->_subscribeAction[$action->id]} = Yii::$app->user->identity->username;
                    }
                },
                'POST pjax' => [
                    'save' => true,
                    'success' => [
                        'class' => ViewAction::class,
                        'view' => '_subscribeButton',
                        'findOptions' => ['with_answers' => 1, 'show_closed' => 1],
                    ],
                ],
            ],
            'unsubscribe' => [
                'class' => SmartPerformAction::class,
                'scenario' => 'answer',
                'success' => Yii::t('hipanel:ticket', 'Unsubscribed'),
                'on beforeSave' => function (Event $event) {
                    /** @var Action $action */
                    $action = $event->sender;
                    foreach ($action->collection->models as $model) {
                        $model->{$this->_subscribeAction[$action->id]} = Yii::$app->user->identity->username;
                    }
                },
                'POST pjax' => [
                    'save' => true,
                    'success' => [
                        'class' => ViewAction::class,
                        'view' => '_subscribeButton',
                        'findOptions' => ['with_answers' => 1, 'show_closed' => 1],
                    ],
                ],
            ],
            'close' => [
                'class' => SmartPerformAction::class,
                'scenario' => 'close',
                'success' => Yii::t('hipanel:ticket', 'Ticket closed'),
                'on beforeSave' => function (Event $event) {
                    /** @var Action $action */
                    $action = $event->sender;
                    foreach ($action->collection->models as $model) {
                        $model->{'state'} = Thread::STATE_CLOSE;
                    }
                },
                'POST pjax' => [
                    'save' => true,
                    'success' => [
                        'class' => ProxyAction::class,
                        'action' => 'view',
                        'params' => function ($action, $model) {
                            return ['id' => $model->id];
                        },
                    ],
                ],
            ],
            'open' => [
                'class' => SmartPerformAction::class,
                'scenario' => 'open',
                'success' => Yii::t('hipanel:ticket', 'Ticket opened'),
                'on beforeSave' => function (Event $event) {
                    /** @var Action $action */
                    $action = $event->sender;
                    foreach ($action->collection->models as $model) {
                        $model->{'state'} = Thread::STATE_OPEN;
                    }
                },
                'POST pjax' => [
                    'save' => true,
                    'success' => [
                        'class' => ProxyAction::class,
                        'action' => 'view',
                        'params' => function ($action, $model) {
                            return ['id' => $model->id];
                        },
                    ],
                ],
            ],
            'update-answer-modal' => [
                'class' => PrepareAjaxViewAction::class,
                'on beforeSave' => function (Event $event) {
                    /** @var PrepareBulkAction $action */
                    $action = $event->sender;
                    $dataProvider = $action->getDataProvider();
                    $dataProvider->query->joinWith('answers');
                },
                'data' => function ($action, $data) {
                    $answer_id = Yii::$app->request->get('answer_id');
                    if (!is_numeric($answer_id)) {
                        throw new NotFoundHttpException('Invalid answer_id');
                    }

                    return ArrayHelper::merge($data, [
                        'answer_id' => $answer_id,
                    ]);
                },
                'findOptions' => $this->getSearchOptions(),
                'scenario' => 'answer-update',
                'view' => '_updateAnswerModal',
            ],
        ]);
    }

    /**
     * @var array
     */
    private $_subscribeAction = ['subscribe' => 'add_watchers', 'unsubscribe' => 'del_watchers'];

    /**
     * @return array
     */
    protected function prepareRefs()
    {
        return [
            'topic_data' => $this->getRefs('topic,ticket', 'hipanel:ticket'),
            'state_data' => $this->getClassRefs('state', 'hipanel:ticket'),
            'priority_data' => $this->getPriorities(),
        ];
    }

    /**
     * @return string
     */
    public function actionSettings()
    {
        $model = new TicketSettings();
        $request = Yii::$app->request;
        if ($request->isAjax && $model->load($request->post()) && $model->validate()) {
            $model->setFormData();
            Yii::$app->getSession()->setFlash('success', Yii::t('hipanel:ticket', 'Ticket settings saved'));
        } else {
            $model->getFormData();
        }

        return $this->render('settings', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionPriorityUp($id)
    {
        $options[$id] = ['id' => $id, 'priority' => 'high'];
        if ($this->_ticketChange($options)) {
            Yii::$app->getSession()->setFlash('success',
                Yii::t('hipanel:ticket', 'Priority has been changed to high'));
        } else {
            Yii::$app->getSession()->setFlash('error',
                Yii::t('hipanel:ticket', 'Some error occurred! Priority has not been changed to high'));
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionPriorityDown($id)
    {
        $options[$id] = ['id' => $id, 'priority' => 'medium'];
        if ($this->_ticketChange($options)) {
            Yii::$app->getSession()->setFlash('success',
                Yii::t('hipanel:ticket', 'Priority has been changed to medium'));
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t('hipanel:ticket', 'Something goes wrong!'));
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Numerous ticket changes in one method, like BladeRoot did :).
     * @param array $options
     * @param string $action
     * @param bool $batch
     * @return bool
     */
    private function _ticketChange($options = [], $action = 'answer', $batch = true)
    {
        try {
            Thread::perform($action, $options, ['batch' => $batch]);
        } catch (ResponseErrorException $e) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function actionGetQuotedAnswer()
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $id = $request->post('id');
            if ($id !== null) {
                try {
                    $answer = Thread::perform('get-answer', ['id' => $id]);
                } catch (ResponseErrorException $e) {
                }
                if (isset($answer['message'])) {
                    return '> ' . str_replace("\n", "\n> ", $answer['message']);
                }
            }
        }
        Yii::$app->end();
    }

    /**
     * @return mixed|string
     */
    public function actionPreview()
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $text = $request->post('text');
            if ($text) {
                return Thread::parseMessage($text);
            }
        }
        Yii::$app->end();
    }

    public function actionGetNewAnswers($id, $answer_id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $result = ['id' => $id, 'answer_id' => $answer_id];

        try {
            $data = Thread::perform('get-last-answer-id', ['id' => $id, 'answer_id' => $answer_id]);
            $result['answer_id'] = $data['answer_id'];
            if ($data['answer_id'] > $answer_id) {
                $dataProvider = (new ThreadSearch())->search([]);
                $dataProvider->query->joinWith('answers');
                $dataProvider->query->andWhere(['id' => $id]);
                $dataProvider->query->andWhere($this->getSearchOptions());
                $models = $dataProvider->getModels();

                $result['html'] = $this->renderPartial('_answers', ['model' => reset($models)]);
            }
        } catch (ResponseErrorException $e) {
        }

        return $result;
    }

    private function getSearchOptions()
    {
        return ['with_anonym' => 1, 'with_answers' => 1, 'with_files' => 1, 'show_closed' => 1];
    }

    public function getPriorities()
    {
        return $this->getRefs('type,priority', 'hipanel:ticket');
    }

    public function actionRenderClientInfo($id)
    {
        $client = Client::find()
            ->where(['id' => $id])
            ->joinWith('contact')
            ->withServers()
            ->withDomains()
            ->one();

        return $this->renderAjax('_clientInfo', ['client' => $client]);
    }
}
