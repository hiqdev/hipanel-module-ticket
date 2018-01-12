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

use hipanel\grid\MainColumn;
use hipanel\grid\SwitchColumn;
use hipanel\modules\client\grid\ClientColumn;
use hipanel\modules\ticket\menus\TemplateActionsMenu;
use hiqdev\yii2\menus\grid\MenuColumn;
use Yii;

class StatisticGridView extends \hipanel\grid\BoxedGridView
{
    public function columns()
    {
        return array_merge(parent::columns(), [
            'client_id' => [
                'class' => ClientColumn::class,
            ],
            'spent' => [
                'value' => function($model) {
                    return $model->spent;
                },
            ],
            'tickets' => [
                'value' => function($model) {
                    return '';
                }
            ],
        ]);
    }
}
