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
                'value' => function($model) {
                    $seconds = $model->spent * 60;
                    $dtF = new \DateTime('@0');
                    $dtT = new \DateTime("@{$seconds}");
                    $r = $dtF->diff($dtT);
                    $d = $r->format('%a');
                    $h = $r->format('%H');
                    $m = $r->format('%I');

                    return Yii::t('hipanel:ticket', '{d, plural, =0{ } one{# day} other{# days}} {h}:{m}', compact('d', 'h', 'm'));
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
