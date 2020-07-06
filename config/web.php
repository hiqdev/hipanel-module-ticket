<?php
/**
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

return [
    'aliases' => [
        '@ticket' => '/ticket/ticket',
        '@ticket/answer' => '/ticket/answer',
        '@ticket/template' => '/ticket/template',
    ],
    'modules' => [
        'ticket' => [
            'class' => \hipanel\modules\ticket\Module::class,
        ],
    ],
    'components' => [
        'i18n' => [
            'translations' => [
                'hipanel:ticket' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => dirname(__DIR__) . '/src/messages',
                ],
            ],
        ],
        'geoip' => [
            'class' => \lysenkobv\GeoIP\GeoIP::class,
        ],
    ],
    'container' => [
        'definitions' => [
            \hipanel\modules\dashboard\menus\DashboardMenu::class => [
                'add' => [
                    'ticket' => [
                        'menu' => [
                            'class' => \hipanel\modules\ticket\menus\DashboardItem::class,
                        ],
                        'where' => [
                            'after' => ['stock', 'server', 'hosting', 'domain', 'client'],
                        ],
                    ],
                ],
            ],
            \hiqdev\thememanager\menus\AbstractSidebarMenu::class => [
                'add' => [
                    'ticket' => [
                        'menu' => [
                            'class' => \hipanel\modules\ticket\menus\SidebarMenu::class,
                        ],
                        'where' => [
                            'after' => ['stock', 'server', 'hosting', 'domain', 'client'],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
