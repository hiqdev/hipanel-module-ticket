<?php

declare(strict_types=1);
/**
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\ticket\grid;

use hipanel\grid\MainColumn;
use hipanel\grid\SwitchColumn;
use hipanel\modules\client\grid\ClientColumn;
use hipanel\modules\ticket\menus\TemplateActionsMenu;
use hiqdev\yii2\menus\grid\MenuColumn;
use Yii;

class TemplateGridView extends \hipanel\grid\BoxedGridView
{
    public function columns()
    {
        return array_merge(parent::columns(), [
            'author_id' => [
                'class' => ClientColumn::class,
                'idAttribute' => 'author_id',
                'attribute' => 'author_id',
                'nameAttribute' => 'author',
            ],
            'post_date' => [
                'value' => fn($model): string => $this->formatter->asDatetime($model->post_date),
            ],
            'actions' => [
                'class' => MenuColumn::class,
                'menuClass' => TemplateActionsMenu::class,
            ],
            'is_published' => [
                'class' => SwitchColumn::class,
                'switchInputOptions' => [
                    'disabled' => true,
                ],
            ],
            'name' => [
                'class' => MainColumn::class,
                'filterAttribute' => 'name_like',
                'contentOptions' => ['style' => 'white-space: break-spaces;'],
            ],
        ]);
    }
}
