<?php

namespace hipanel\modules\ticket\menus;

use hiqdev\menumanager\Menu;
use Yii;

class TemplateActionsMenu extends Menu
{
    public $model;

    public function items()
    {
        return [
            [
                'label' => Yii::t('hipanel', 'Update'),
                'icon' => 'fa-pencil',
                'url' => ['@ticket/template/update', 'id' => $this->model->id],
            ],
            [
                'label' => Yii::t('hipanel', 'Delete'),
                'icon' => 'fa-trash',
                'url' => ['@ticket/template/delete', 'id' => $this->model->id],
                'linkOptions' => [
                    'data' => [
                        'confirm' => Yii::t('hipanel', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                        'pjax' => '0',
                    ]
                ],
            ],
        ];
    }
}
