<?php

namespace hipanel\modules\ticket\tests\acceptance\admin;

use hipanel\tests\_support\Page\SidebarMenu;
use hipanel\tests\_support\Step\Acceptance\Admin;

class TicketSidebarMenuCest
{
    public function ensureMenuIsOk(Admin $I)
    {
        $menu = new SidebarMenu($I);
        $menu->ensureContains('Support', [
            'Tickets' => '@ticket/index',
            'Templates' => '@ticket/template/index',
        ]);
        $menu->ensureDoesNotContain('Support', [
            'Tickets statistics',
        ]);
    }
}
