<?php

namespace hipanel\modules\ticket\tests\acceptance\client;

use hipanel\tests\_support\Page\SidebarMenu;
use hipanel\tests\_support\Step\Acceptance\Client;

class TicketSidebarMenuCest
{
    public function ensureMenuIsOk(Client $I)
    {
        $menu = new SidebarMenu($I);

        $menu->ensureContains('Support', [
            'Tickets' => '@ticket/index',
            'FAQ' => '/faq/faq/index',
        ]);

        $menu->ensureDoesNotContain('Support', [
            'Templates',
            'Tickets statistics',
        ]);
    }
}
