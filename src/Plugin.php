<?php
/**
 * @link    http://hiqdev.com/hipanel-module-ticket
 * @license http://hiqdev.com/hipanel-module-ticket/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\ticket;

class Plugin extends \hiqdev\pluginmanager\Plugin
{
    protected $_items = [
        'aliases' => [
            "@ticket" => "/ticket/ticket",
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
