<?php
/**
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\ticket\menus;

use hipanel\modules\ticket\models\Thread;
use Yii;

class TicketActionsMenu extends \hiqdev\yii2\menus\Menu
{
    public $model;

    public function items()
    {
        return [
            [
                'label' => Yii::t('hipanel', 'View'),
                'icon' => 'fa-info',
                'url' => ['@ticket/view', 'id' => $this->model->id],
            ],
            [
                'label' => $this->model->state === Thread::STATE_OPEN ? Yii::t('hipanel:ticket', 'Close') : Yii::t('hipanel:ticket', 'Open'),
                'icon' => $this->model->state === Thread::STATE_OPEN ? 'fa-times' : 'fa-envelope-open-o',
                'url' => $this->model->state === Thread::STATE_OPEN ? ['@ticket/close', 'id' => $this->model->id] : ['@ticket/open', 'id' => $this->model->id],
            ],
        ];
    }
}
