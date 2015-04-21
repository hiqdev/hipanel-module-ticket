<?php
/**
 * @link    http://hiqdev.com/hipanel-module-ticket
 * @license http://hiqdev.com/hipanel-module-ticket/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\ticket\grid;

use hipanel\grid\MainColumn;

class TicketGridView extends \hipanel\grid\BoxedGridView
{
    static public function defaultColumns()
    {
        return [
            'ticket' => [
                'class'                 => MainColumn::className(),
                'filterAttribute'       => 'ticket_like',
            ],
        ];
    }
}
