<?php

/*
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\ticket;

use Yii;

class SidebarMenu extends \hipanel\base\Menu implements \yii\base\BootstrapInterface
{
    protected $_addTo = 'sidebar';

    protected $_where = [
        'after' => ['finance', 'clients', 'dashboard', 'header'],
        'before' => ['domains', 'servers', 'hosting'],
    ];

    public function items()
    {
        return [
            'tickets' => [
                'label' => Yii::t('hipanel/ticket', 'Tickets'),
                'url' => ['/ticket/ticket/index'],
                'icon' => 'fa-ticket',
                'items' => [
                    'tickets' => [
                        'label' => Yii::t('hipanel/ticket', 'Tickets'),
                        'url' => ['/ticket/ticket/index'],
                    ],
                    'templates' => [
                        'label' => Yii::t('hipanel/ticket', 'Templates'),
                        'url' => ['/ticket/template/index'],
                        'visible' => function () {
                            return Yii::$app->user->can('support');
                        },
                    ],
//                  'statistics' => [
//                      'label' => Yii::t('hipanel/ticket', 'Tickets statistics'),
//                      'url'   => ['/ticket/ticket/statistics'],
//                  ],
                ],
            ],
        ];
    }
}
