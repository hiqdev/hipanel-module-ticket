<?php

/*
 * Ticket Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hipanel\modules\ticket\controllers;

use common\models\File;
use hipanel\actions\Action;
use hipanel\actions\IndexAction;
use hipanel\actions\ProxyAction;
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartPerformAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\modules\client\models\Client;
use hipanel\modules\ticket\models\Thread;
use hipanel\modules\ticket\models\TicketSettings;
use hiqdev\hiart\ErrorResponseException;
use Yii;
use yii\base\Event;

/**
 * Class TicketController.
 */
class TicketController extends \hipanel\base\CrudController
{
    /**
     * Used to create newModel.
     *
     * @return string
     */
    public static function modelClassName()
    {
        return Thread::className();
    }


    public function actions()
    {
        return [
            'index'         => [
                'class' => IndexAction::class,
                'data'  => $this->prepareRefs(),
            ],
            'view'          => [
                'class'       => ViewAction::class,
                'findOptions' => ['with_anonym' => 1, 'with_answers' => 1, 'with_files' => 1, 'show_closed' => 1],
                'data'        => function ($action) {
                    $client = Client::find()->where([
                        'id'                 => $action->model->recipient_id,
                        'with_contact'       => 1,
                        'with_domains_count' => Yii::getAlias('@domain', false) ? 1 : 0,
                        'with_servers_count' => 1,
                        'with_hosting_count' => 1,
                    ])->one();
                    if ($client->login == 'anonym') {
                        $client->name   = $action->model->anonym_name;
                        $client->email  = $action->model->anonym_email;
                        $client->seller = $action->model->anonym_seller;
                    }
                    return array_merge(compact('client'), $this->prepareRefs());
                },
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
            'answer'        => [
                'class'   => SmartUpdateAction::class,
                'success' => Yii::t('hipanel/ticket', 'Ticket changed'),
            ],
            'create'        => [
                'class'   => SmartCreateAction::class,
                'success' => Yii::t('hipanel/ticket', 'Ticket posted'),
                'data'    => function () { return $this->prepareRefs(); },
            ],
            'delete'        => [
                'class'   => SmartPerformAction::class,
                'success' => Yii::t('hipanel/ticket', 'Ticket deleted'),
            ],
            'subscribe'     => [
                'class'      => SmartPerformAction::class,
                'scenario'   => 'answer',
                'success'    => Yii::t('hipanel/ticket', 'Subscribed'),
                'on beforeSave' => function (Event $event) {
                    /** @var Action $action */
                    $action = $event->sender;
                    foreach ($action->collection->models as $model) {
                        $model->{$this->_subscribeAction[$action->id]} = Yii::$app->user->identity->username;
                    }
                },
                'POST pjax'  => [
                    'save'    => true,
                    'success' => [
                        'class'       => ViewAction::class,
                        'view'        => '_subscribe_button',
                        'findOptions' => ['with_answers' => 1],
                    ],
                ],
            ],
            'unsubscribe'   => [
                'class'      => SmartPerformAction::class,
                'scenario'   => 'answer',
                'success'    => Yii::t('hipanel/ticket', 'Unsubscribed'),
                'on beforeSave' => function (Event $event) {
                    /** @var Action $action */
                    $action = $event->sender;
                    foreach ($action->collection->models as $model) {
                        $model->{$this->_subscribeAction[$action->id]} = Yii::$app->user->identity->username;
                    }
                },
                'POST pjax'  => [
                    'save'    => true,
                    'success' => [
                        'class'       => ViewAction::class,
                        'view'        => '_subscribe_button',
                        'findOptions' => ['with_answers' => 1],
                    ],
                ],
            ],
            'close'         => [
                'class'      => SmartPerformAction::class,
                'scenario'   => 'answer',
                'success'    => Yii::t('hipanel/ticket', 'Ticket closed'),
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
                        }
                    ]
                ]
            ],
            'open'          => [
                'class'      => SmartPerformAction::class,
                'scenario'   => 'answer',
                'success'    => Yii::t('hipanel/ticket', 'Ticket opened'),
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
                        }
                    ]
                ]
            ],
        ];
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
            'topic_data'    => $this->getRefs('topic,ticket'),
            'state_data'    => $this->GetClassRefs('state'),
            'priority_data' => $this->getPriorities(),
        ];
    }

    /**
     * @return string
     */
    public function actionSettings()
    {
        $model   = new TicketSettings();
        $request = Yii::$app->request;
        if ($request->isAjax && $model->load($request->post()) && $model->validate()) {
            $model->setFormData();
            \Yii::$app->getSession()->setFlash('success', \Yii::t('hipanel/ticket', 'Ticket settings saved'));
        } else {
            $model->getFormData();
        }

        return $this->render('settings', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     *
     * @return \yii\web\Response
     */
    public function actionPriorityUp($id)
    {
        $options[$id] = ['id' => $id, 'priority' => 'high'];
        if ($this->_ticketChange($options)) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('hipanel/ticket', 'Priority has been changed to high'));
        } else {
            \Yii::$app->getSession()->setFlash('error', \Yii::t('hipanel/ticket', 'Some error occurred! Priority has not been changed to high'));
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param $id
     *
     * @return \yii\web\Response
     */
    public function actionPriorityDown($id)
    {
        $options[$id] = ['id' => $id, 'priority' => 'medium'];
        if ($this->_ticketChange($options)) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('hipanel/ticket', 'Priority has been changed to medium'));
        } else {
            \Yii::$app->getSession()->setFlash('error', \Yii::t('hipanel/ticket', 'Something goes wrong!'));
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Numerous ticket changes in one method, like BladeRoot did :).
     *
     * @param array $options
     * @param string $apiCall
     * @param bool $bulk
     *
     * @return bool
     */
    private function _ticketChange($options = [], $apiCall = 'Answer', $bulk = true)
    {
        try {
            Thread::perform($apiCall, $options, $bulk);
        } catch (ErrorResponseException $e) {
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
                    $answer = Thread::perform('GetAnswer', ['id' => $id]);
                } catch (ErrorResponseException $e) {}
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

    /**
     * @param $id
     * @param $object_id
     *
     * @return array|bool
     */
    public function actionFileView($id, $object_id)
    {
        return File::renderFile($id, $object_id, 'thread', true);
    }
}
