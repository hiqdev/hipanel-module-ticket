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

class Plugin extends \hiqdev\pluginmanager\Plugin
{
    protected $_items = [
        'aliases' => [
            '@ticket' => '/ticket/ticket',
        ],
        'menus' => [
            [
                'class' => 'hipanel\modules\ticket\SidebarMenu',
            ],
        ],
        'modules' => [
            'ticket' => [
                'class' => 'hipanel\modules\ticket\Module',
            ],
        ],
    ];
}
