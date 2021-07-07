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

use hipanel\modules\client\grid\ClientColumn;
use hipanel\widgets\ClientSellerLink;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;

class StatisticGridView extends \hipanel\grid\BoxedGridView
{
    public function columns()
    {
        return array_merge(parent::columns(), [
            'client_id' => [
                'class' => ClientColumn::class,
                'label' => Yii::t('hipanel', 'Client'),
                'idAttribute' => 'client_id',
                'sortAttribute' => 'client',
                'attribute' => 'client_id',
                'value' => function ($model) {
                    return ClientSellerLink::widget(compact('model'));
                },
            ],
            'spent' => [
                'label' => Yii::t('hipanel:ticket', 'Spent'),
                'filter' => false,
                'contentOptions' => ['nowrap' => true],
                'value' => function ($model) {
                    return Yii::t('hipanel:ticket', '{d, plural, =0{ } one{# day} other{# days}} {h}:{m}', [
                        'd' => floor($model->spent / 60 / 24),
                        'h' => sprintf('%02d', floor($model->spent / 60) % 24),
                        'm' => sprintf('%02d', floor($model->spent % 60)),
                    ]);
                },
            ],
            'threads_num' => [
                'label' => Yii::t('hipanel:ticket', 'Threads'),
                'filter' => false,
            ],
            'answers_num' => [
                'label' => Yii::t('hipanel:ticket', 'Answers'),
                'filter' => false,
            ],
            'tickets' => [
                'format' => 'html',
                'label' => Yii::t('hipanel:ticket', 'Tickets'),
                'value' => function($model) {
                    foreach (explode(",", $model->thread_ids) as $thread) {
                        $threads[$thread] = Html::a($thread, Url::to(['@ticket/view', 'id' => $thread]));
                    }
                    ksort($threads);
                    return implode(" ", $threads);
                }
            ],
        ]);
    }
}
