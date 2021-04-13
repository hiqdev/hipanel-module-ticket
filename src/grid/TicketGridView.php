<?php
/**
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\ticket\grid;

use hipanel\grid\BoxedGridView;
use hipanel\modules\client\grid\ClientColumn;
use hipanel\modules\ticket\assets\ThreadListCheckerAsset;
use hipanel\modules\ticket\menus\TicketActionsMenu;
use hipanel\modules\ticket\models\Thread;
use hipanel\modules\ticket\widgets\ThreadDecorator;
use hipanel\modules\ticket\widgets\Topic;
use hipanel\widgets\ClientSellerLink;
use hipanel\widgets\Gravatar;
use hiqdev\yii2\menus\grid\MenuColumn;
use Yii;
use yii\helpers\Html;
use yii\helpers\Json;

class TicketGridView extends BoxedGridView
{
    public $enableListChecker = false;

    public function columns()
    {
        return array_merge(parent::columns(), [
            'subject' => [
                'attribute' => 'subject',
                'format' => 'html',
                'filterInputOptions' => ['style' => 'width:100%', 'class' => 'form-control'],
                'value' => function ($model) {
                    $decorator = new ThreadDecorator($model);

                    $ava = Html::tag('div', Gravatar::widget([
                        'emailHash' => $model->author_email,
                        'defaultImage' => 'identicon',
                        'options' => [
                            'alt' => Yii::t('hipanel:ticket', 'Avatar for {login}', ['login' => $model->author]),
                            'class' => 'img-circle',
                        ],
                        'size' => 40,
                    ]), ['class' => 'pull-right']);

                    $titleLink = [
                        Html::a($decorator->subject, $model->threadUrl, [
                            'class' => 'text-bold',
                            'style' => $model->state === Thread::STATE_CLOSE ? 'color: black !important;' : '',
                        ]),
                        Topic::widget(['topics' => $model->topics]),
                        Html::tag(
                            'div',
                            sprintf('#%s %s %s',
                                $model->id,
                                Html::tag('span', Yii::t('hipanel:ticket', $model->state_label), ['class' => 'text-bold']),
                                Yii::$app->formatter->asDatetime($model->create_time)
                            ),
                            ['class' => 'text-muted']
                        ),
                    ];

                    return $ava . Html::tag('div', implode('', $titleLink));
                },
            ],
            'author_id' => [
                'class' => ClientColumn::class,
                'label' => Yii::t('hipanel:ticket', 'Author'),
                'idAttribute' => 'author_id',
                'sortAttribute' => 'author',
                'attribute' => 'author_id',
                'value' => function ($model) {
                    return ClientSellerLink::widget(compact('model'));
                },
            ],
            'responsible_id' => [
                'class' => ClientColumn::class,
                'idAttribute' => 'responsibles',
                'sortAttribute' => 'responsible',
                'attribute' => 'responsible',
                'clientType' => ['admin', 'reseller', 'manager'],
                'value' => function ($model) {
                    return Html::a($model['responsible'], ['/client/client/view', 'id' => $model->responsible_id]);
                },
                'visible' => Yii::$app->user->can('support'),
            ],
            'recipient_id' => [
                'class' => ClientColumn::class,
                'idAttribute' => 'recipient_id',
                'label' => Yii::t('hipanel:ticket', 'Recipient'),
                'sortAttribute' => 'recipient',
                'attribute' => 'recipient_id',
                'value' => function ($model) {
                    return Html::a($model->recipient, ['/client/client/view', 'id' => $model->recipient_id]);
                },
                'visible' => Yii::$app->user->can('support'),
            ],
            'answer_count' => [
                'attribute' => 'answer_count',
                'label' => Yii::t('hipanel:ticket', 'Answers'),
                'format' => 'html',
                'filter' => false,
                'enableSorting' => false,
                'value' => function ($model) {
                    $lastAnswer = [
                        ClientSellerLink::widget([
                            'model' => $model,
                            'clientAttribute' => 'replier',
                            'clientIdAttribute' => 'replier_id',
                            'sellerAttribute' => false,
                        ]), '<br>',

                        Html::tag('span', Yii::$app->formatter->asRelativeTime($model->reply_time), [
                            'style' => 'font-size: smaller;white-space: nowrap;',
                            'class' => 'text-muted',
                        ]), '&nbsp;&nbsp;',

                        Html::tag('span', $model->answer_count, [
                            'class' => 'label label-default',
                            'title' => Yii::t('hipanel:ticket',
                                'Ticket contains {n, plural, one{# answer} other{# answers}}',
                                ['n' => $model->answer_count]
                            ),
                        ]),
                    ];

                    return implode('', $lastAnswer);
                },
                'contentOptions' => [
                    'class' => 'answer',
                ],
            ],
            'actions' => [
                'class' => MenuColumn::class,
                'menuClass' => TicketActionsMenu::class,
            ],
        ]);
    }

    public function run()
    {
        if ($this->enableListChecker) {
            ThreadListCheckerAsset::register($this->view);
            $options = Json::encode(['pjaxSelector' => '#ticket-grid-pjax']);
            $this->view->registerJs("$('#ticket-grid-pjax').closest('form').parent().threadListChecker($options);");
        }

        parent::run();
    }
}
