<?php

namespace hipanel\modules\ticket\tests\acceptance\seller;

use hipanel\tests\_support\Page\SidebarMenu;
use hipanel\tests\_support\Step\Acceptance\Seller;

class TicketSidebarMenuCest
{
    public function ensureMenuIsOk(Seller $I)
    {
        (new SidebarMenu($I))->ensureContains('Support', [
            'Tickets' => '@ticket/index',
            'Templates' => '@ticket/template/index',
            'Tickets statistics' => '/ticket/statistic/index',
            'FAQ' => '/faq/faq/index',
        ]);
    }
}
