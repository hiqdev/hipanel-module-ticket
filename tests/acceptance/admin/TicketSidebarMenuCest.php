<?php

namespace hipanel\modules\ticket\tests\acceptance\admin;

use hipanel\tests\_support\Page\SidebarMenu;
use hipanel\tests\_support\Step\Acceptance\Admin;

class TicketSidebarMenuCest
{
    public function ensureMenuIsOk(Admin $I)
    {
        (new SidebarMenu($I))->ensureContains('Support', [
            'Tickets' => '@ticket/index',
            'Templates' => '@ticket/template/index',
            'Tickets statistics' => '/ticket/statistic/index',
            'FAQ' => '/faq/faq/index',
        ]);
    }
}
