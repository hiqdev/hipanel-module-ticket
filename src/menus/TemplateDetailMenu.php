<?php

namespace hipanel\modules\ticket\menus;

use hiqdev\menumanager\Menu;

class TemplateDetailMenu extends Menu
{
    public $model;

    public function items()
    {
        $actions = TemplateActionsMenu::create(['model' => $this->model])->items();
        $items = array_merge($actions, []);

        return $items;
    }
}
