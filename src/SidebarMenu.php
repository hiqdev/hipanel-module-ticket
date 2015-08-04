<?php

/*
 * Ticket Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hipanel\modules\ticket;

class SidebarMenu extends \hipanel\base\Menu implements \yii\base\BootstrapInterface
{
    protected $_addTo = 'sidebar';

    protected $_where = [
        'after'  => ['finance', 'clients', 'dashboard', 'header'],
        'before' => ['domains', 'servers', 'hosting'],
    ];

    protected $_items = [
        'tickets' => [
            'label' => 'Tickets',
            'url'   => ['/ticket/ticket/index'],
            'icon'  => 'fa-ticket',
            'items' => [
                'tickets' => [
                    'label' => 'Tickets',
                    'url'   => ['/ticket/ticket/index'],
                ],
                'settings' => [
                    'label' => 'Tickets settings',
                    'url'   => ['/ticket/ticket/settings'],
                ],
                'statistics' => [
                    'label' => 'Tickets statistic',
                    'url'   => ['/ticket/ticket/statistics'],
                ],
            ],
        ],
    ];
}
