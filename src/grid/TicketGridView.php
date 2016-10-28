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
                    $isClosed = $model->state === Thread::STATE_CLOSE;
                    $titleLink = Html::a($model->subject, $model->threadUrl, ['class' => 'text-bold', 'style' => (($isClosed) ? 'color: black!important;' : '')]) .
                        Topic::widget(['topics' => $model->topics]) .
                        Html::tag('div', sprintf('#%s %s %s', $model->id,
                            Html::tag('span', Yii::t('hipanel/ticket', $model->state_label), ['class' => 'text-bold']),
                            Yii::$app->formatter->asDatetime($model->create_time)), ['class' => 'text-muted']);

                    return $ava . Html::tag('div', $titleLink);
                },
            ],
            'author_id' => [
                'class' => ClientColumn::class,
                'label' => Yii::t('hipanel/ticket', 'Author'),
                'idAttribute' => 'author_id',
                'sortAttribute' => 'author',
                'attribute' => 'author_id',
                'value' => function ($model) {
                    return ClientSellerLink::widget(compact('model'));
                },
            ],
            'responsible_id' => [
                'class' => ClientColumn::class,
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
                'class' => ClientColumn::class,
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
                    $answerCount = sprintf('<span class="label label-default">&nbsp;%d&nbsp;</span>', $model->answer_count);
                    $lastAnswer = Html::a(
                            $model->replier,
                            ['@client/view', 'id' => $model->replier_id],
                            ['class' => '']) . '<br>' .
                        Html::tag('span', Yii::$app->formatter->asRelativeTime($model->reply_time), ['style' => 'font-size: smaller;white-space: nowrap;', 'class' => 'text-muted']) .
                        '&nbsp;&nbsp;' . $answerCount;

                    return $lastAnswer;
                },
                'contentOptions' => [
                    'class' => 'answer',
                ],
            ],
            'actions' => [
                'class' => ActionColumn::class,
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
        ];
    }
}
