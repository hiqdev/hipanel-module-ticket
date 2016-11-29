<?php

namespace hipanel\modules\ticket\menus;

use hiqdev\menumanager\Menu;

class TicketDetailMenu extends Menu
{
    public $model;

    public function items()
    {
        $actions = TicketActionsMenu::create(['model' => $this->model])->items();
        $items = array_merge($actions, []);

        return $items;
    }
}
