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
                    $ss = $model->spent * 60;

                    return Yii::t('hipanel:ticket', '{d, plural, =0{ } one{# day} other{# days}} {h}:{m}', [
                        'd' => floor(($ss % 2592000) / 86400),
                        'h' => sprintf('%02d', floor(($ss % 86400) / 3600)),
                        'm' => sprintf('%02d', floor(($ss % 3600) / 60)),
                    ]);
                },
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
