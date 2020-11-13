<?php
/**
 * Domain plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-domain
 * @package   hipanel-module-domain
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\ticket\menus;

use hipanel\helpers\Url;
use hipanel\modules\client\ClientWithCounters;
use hiqdev\yii2\menus\Menu;
use Yii;

class DashboardItem extends Menu
{
    protected ClientWithCounters $clientWithCounters;

    public function __construct(ClientWithCounters $clientWithCounters, $config = [])
    {
        $this->clientWithCounters = $clientWithCounters;
        parent::__construct($config);
    }

    public function items()
    {
        return Yii::$app->user->can('ticket.read') ? [
            'ticket' => [
                'label' => $this->render('dashboardItem', array_merge($this->clientWithCounters->getWidgetData('ticket'), [
                    'route' => Url::toRoute('@ticket/index'),
                ])),
                'encode' => false,
            ],
        ] : [];
    }
}
