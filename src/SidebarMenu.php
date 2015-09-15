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

use Yii;

class SidebarMenu extends \hipanel\base\Menu implements \yii\base\BootstrapInterface
{
    protected $_addTo = 'sidebar';

    protected $_where = [
        'after'  => ['finance', 'clients', 'dashboard', 'header'],
        'before' => ['domains', 'servers', 'hosting'],
    ];

    public function items()
    {
        return [
            'tickets' => [
                'label' => Yii::t('app', 'Tickets'),
                'url'   => ['/ticket/ticket/index'],
                'icon'  => 'fa-ticket',
                'items' => [
                    'tickets' => [
                        'label' => Yii::t('app', 'Tickets'),
                        'url'   => ['/ticket/ticket/index'],
                    ],
                    'settings' => [
                        'label' => Yii::t('app', 'Tickets settings'),
                        'url'   => ['/ticket/ticket/settings'],
                    ],
//                  'statistics' => [
//                      'label' => Yii::t('app', 'Tickets statistics'),
//                      'url'   => ['/ticket/ticket/statistics'],
//                  ],
                ],
            ],
        ];
    }
}
