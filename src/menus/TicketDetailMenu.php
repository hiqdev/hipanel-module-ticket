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

namespace hipanel\modules\ticket\menus;

use hipanel\widgets\AuditButton;

class TicketDetailMenu extends \hipanel\menus\AbstractDetailMenu
{
    public $model;

    public function items()
    {
        $actions = TicketActionsMenu::create(['model' => $this->model])->items();
        $items = [
            [
                'label' => AuditButton::widget(['model' => $this->model, 'linkOptions' => ['style' => 'text-align: center;']]),
                'encode' => false,
                'visible' => !$this->model->isNewRecord,
            ]
        ];

        return $items;
    }
}
