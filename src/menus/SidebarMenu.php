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

use Yii;

class SidebarMenu extends \hiqdev\yii2\menus\Menu
{
    public function items()
    {
        return [
            'tickets' => [
                'label' => Yii::t('hipanel:ticket', 'Support'),
                'url' => ['/ticket/ticket/index'],
                'icon' => 'fa-life-ring',
                'items' => [
                    'tickets' => [
                        'label' => Yii::t('hipanel:ticket', 'Tickets'),
                        'url' => ['/ticket/ticket/index'],
                        'visible' => Yii::$app->user->can('ticket.read'),
                    ],
                    'templates' => [
                        'label' => Yii::t('hipanel:ticket', 'Templates'),
                        'url' => ['/ticket/template/index'],
                        'visible' => Yii::$app->user->can('support'),
                    ],
//                  'statistics' => [
//                      'label' => Yii::t('hipanel:ticket', 'Tickets statistics'),
//                      'url'   => ['/ticket/ticket/statistics'],
//                  ],
                ],
            ],
        ];
    }
}
