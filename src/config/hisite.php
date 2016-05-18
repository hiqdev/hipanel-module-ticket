<?php

return [
    'aliases' => [
        '@ticket' => '/ticket/ticket',
        '@ticket/answer' => '/ticket/answer',
    ],
    'modules' => [
        'ticket' => [
            'class' => 'hipanel\modules\ticket\Module',
        ],
    ],
    'components' => [
        'i18n' => [
            'translations' => [
                'hipanel/ticket*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@hipanel/modules/ticket/messages',
                    'fileMap' => [
                        'hipanel/ticket' => 'ticket.php',
                    ],
                ],
            ],
        ],
        'menuManager' => [
            'menus' => [
                'ticket' => 'hipanel\modules\ticket\SidebarMenu',
            ],
        ],
    ],
];
