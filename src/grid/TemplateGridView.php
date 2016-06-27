<?php

/*
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\ticket\grid;

use hipanel\grid\ActionColumn;
use hipanel\grid\SwitchColumn;
use hipanel\modules\client\grid\ClientColumn;
use Yii;
use yii\helpers\Html;

class TemplateGridView extends \hipanel\grid\BoxedGridView
{
    public static function defaultColumns()
    {
        return [
            'author_id' => [
                'class' => ClientColumn::class,
                'idAttribute' => 'author_id',
                'attribute' => 'author_id',
                'nameAttribute' => 'author',
            ],
            'post_date' => [
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->post_date);
                }
            ],
            'actions' => [
                'class' => ActionColumn::className(),
                'template' => '{view}{delete}',
                'header' => Yii::t('hipanel', 'Actions'),
            ],
            'is_published' => [
                'class' => SwitchColumn::class,
                'switchInputOptions' => [
                    'disabled' => true
                ]
            ],
            'name' => [
                'filterAttribute' => 'name_like',
            ]
        ];
    }
}
