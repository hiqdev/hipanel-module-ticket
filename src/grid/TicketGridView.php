<?php

/*
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\ticket\grid;

use hipanel\grid\ActionColumn;
use hipanel\grid\BoxedGridView;
use hipanel\modules\client\grid\ClientColumn;
use hipanel\modules\ticket\models\Thread;
use hipanel\modules\ticket\widgets\Topic;
use hipanel\widgets\ClientSellerLink;
use hipanel\widgets\Gravatar;
use Yii;
use yii\helpers\Html;

class TicketGridView extends BoxedGridView
{
    public static function defaultColumns()
    {
        return [
            'subject' => [
                'attribute' => 'subject',
                'format' => 'raw',
                'filterInputOptions' => ['style' => 'width:100%', 'class' => 'form-control'],
                'value' => function ($model) {
                    $ava = Html::tag('div', Gravatar::widget([
                        'emailHash' => $model->author_email,
                        'defaultImage' => 'identicon',
                        'options' => [
                            'alt' => '',
                            'class' => 'img-circle',
                        ],
                        'size' => 40,
                    ]), ['class' => 'pull-right']);
                    $state = $model->state === 'opened'
                        ? Html::tag('div', '<span class="fa fa-circle-o text-muted"></span>', ['class' => 'table-list-cell table-list-cell-type'])
                        : Html::tag('div', '<span class="fa fa-check-circle text-muted"></span>', ['class' => 'table-list-cell table-list-cell-type']);
                    $t = Html::tag('b', Html::a($model->subject, $model->threadUrl)) . Topic::widget(['topics' => $model->topics]) .
                        Html::tag('div', sprintf('#%s %s %s', $model->id, $model->state_label, Yii::$app->formatter->asDatetime($model->create_time)), ['class' => 'text-muted']);

                    $lastAnswer = Html::a(
                            Yii::t('hipanel/ticket', 'Last answer') . ': ' . $model->replier_name . ' ' . Yii::$app->formatter->asDatetime($model->reply_time),
                            ['@client/view', 'id' => $model->replier_id],
                            ['class' => 'label label-default', 'style' => 'font-size: x-small;']);
                    return $ava . $state . Html::tag('div', $t, ['class' => 'table-list-cell table-list-title']);
                },

            ],
            'author_id' => [
                'class' => ClientColumn::className(),
                'label' => Yii::t('hipanel/ticket', 'Author'),
                'idAttribute' => 'author_id',
                'sortAttribute' => 'author',
                'attribute' => 'author_id',
                'value' => function ($model) {
                    return ClientSellerLink::widget(compact('model'));
                },
            ],
            'responsible_id' => [
                'class' => ClientColumn::className(),
                'idAttribute' => 'responsible_id',
                'sortAttribute' => 'responsible',
                'attribute' => 'responsible_id',
                'clientType' => ['admin', 'seller', 'manager'],
                'value' => function ($model) {
                    return Html::a($model['responsible'], ['/client/client/view', 'id' => $model->responsible_id]);
                },
                'visible' => Yii::$app->user->can('support'),
            ],
            'recipient_id' => [
                'class' => ClientColumn::className(),
                'idAttribute' => 'recipient_id',
                'label' => Yii::t('hipanel/ticket', 'Recipient'),
                'sortAttribute' => 'recipient',
                'attribute' => 'recipient_id',
                'value' => function ($model) {
                    return Html::a($model->recipient, ['/client/client/view', 'id' => $model->recipient_id]);

                },
                'visible' => Yii::$app->user->can('support'),
            ],
            'answer_count' => [
                'attribute' => 'answer_count',
                'label' => Yii::t('hipanel/ticket', 'Answers'),
                'format' => 'raw',
                'filter' => false,
                'enableSorting' => false,
                'value' => function ($model) {
//                    $html = Html::tag('span', '', ['class' => 'glyphicon glyphicon-comment text-muted']) . '&nbsp;&nbsp;' . $model->answer_count;
//                    $html = sprintf('<span class="fa-stack text-muted"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-stack-1x" style="font-size: small">%d</i></span>', $model->answer_count);
                    $answerCount = sprintf('<span class="label label-default">&nbsp;%d&nbsp;</span>', $model->answer_count);
                    $lastAnswer = Html::a(
                        $model->replier,
                        ['@client/view', 'id' => $model->replier_id],
                        ['class' => '']) . '<br>' .
                        Html::tag('span', Yii::$app->formatter->asRelativeTime($model->reply_time), ['style' => 'font-size: smaller;', 'class' => 'text-muted']) .
                        '&nbsp;&nbsp;' . $answerCount;
                    return $lastAnswer;
                },
                'contentOptions' => [
                    'class' => 'answer'
                ],
            ],
            'actions' => [
                'class' => ActionColumn::className(),
                'template' => '{view} {state}',
                'header' => Yii::t('hipanel', 'Actions'),
                'buttons' => [
                    'state' => function ($url, $model, $key) {
                        $out = '';
                        if ($model->state === Thread::STATE_OPEN) {
                            $out .= Html::a(Yii::t('hipanel/ticket', 'Close'), ['close', 'id' => $model->id]);
                        } elseif ($model->state === Thread::STATE_CLOSE) {
                            $out .= Html::a(Yii::t('hipanel/ticket', 'Open'), ['open', 'id' => $model->id]);
                        }
                        return $out;
                    },
                ],
            ],
//            [
//                'attribute' => 'responsible_id',
//                'format'    => 'html',
//                //            'filterInputOptions' => ['id' => 'responsible_id'],
//                'value' => function ($data) {
//                    return Html::a($data['responsible'], ['/client/client/view', 'id' => $data->responsible_id]);
//                },
//                'filter' => \hipanel\modules\client\widgets\combo\ClientCombo::widget([
//                    'attribute'           => 'responsible_id',
//                    'model'               => $model,
//                    'formElementSelector' => 'td',
//                    'inputOptions'        => [
//                        'id' => 'responsible_id',
//                    ],
//                ]),
//            ],
//            [
//                'attribute' => 'recipient_id',
//                'format'    => 'html',
//                'label'     => Yii::t('hipanel/ticket', 'Recipient'),
//                'value'     => function ($data) {
//                    return Html::a($data->recipient, ['/client/client/view', 'id' => $data->recipient_id]);
//
//                },
//                'filter' => \hipanel\modules\client\widgets\combo\ClientCombo::widget([
//                    'attribute'           => 'recipient_id',
//                    'model'               => $model,
//                    'formElementSelector' => 'td',
//                    'inputOptions'        => [
//                        'id' => 'recipient_id',
//                    ],
//                ]),
//            ],
//            [
//                'attribute'     => 'answer_count',
//                'label'         => Yii::t('hipanel/ticket', 'Answers'),
//                'format'        => 'raw',
//                'filter'        => false,
//                'enableSorting' => false,
//                'value'         => function ($data) {
//                    return Html::tag('span', '', ['class' => 'glyphicon glyphicon-comment text-muted']) . '&nbsp;&nbsp;' . $data->answer_count;
//                },
//                'contentOptions' => [
//                    'style' => 'font-size: larger;',
//                ],
//            ],
//            [
//                'class'    => ActionColumn::className(),
//                'template' => '{view}',
//                'header'   => Yii::t('hipanel/ticket', 'Actions'),
//                'buttons'  => [
//                    //                'view' => function ($url, $model, $key) {
//                    //                    return GridActionButton::widget([
//                    //                        'url' => $url,
//                    //                        'icon' => '<i class="fa fa-eye"></i>',
//                    //                        'label' => Yii::t('hipanel/ticket', 'Details'),
//                    //                    ]);
//                    //                },
//                    'state' => function ($url, $model, $key) {
//                        if ($model->state === 'opened') {
//                            //                        $title = Yii::t('hipanel/ticket', 'Close');
//                            //                        return Html::a('<i class="fa fa-times"></i>&nbsp;&nbsp;'.$title,
//                            //                            ['close', 'id' => $model->id],
//                            //                            ['title' => $title, 'class' => 'btn btn-default btn-xs', 'data-pjax' => 0]
//                            //                        );
//                            return Html::a('Close', ['close', 'id' => $model->id]);
//                            //                        GridActionButton::widget([
//                            //                            'url' => ['close', 'id' => $model->id],
//                            //                            'icon' => '<i class="fa fa-times"></i>',
//                            //                            'label' => Yii::t('hipanel/ticket', 'Close'),
//                            //                        ]);
//                        }
//                    },
//                ],
//            ],
        ];
    }
}
