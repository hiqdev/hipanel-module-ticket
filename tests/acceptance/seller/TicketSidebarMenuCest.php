<?php

namespace hipanel\modules\ticket\tests\acceptance\seller;

use hipanel\tests\_support\Page\SidebarMenu;
use hipanel\tests\_support\Step\Acceptance\Seller;
use yii\helpers\Url;

class TicketSidebarMenuCest
{
    public function ensureMenuIsOk(Seller $I)
    {
        $I->login();
        $menu = new SidebarMenu($I);

        $I->amOnPage(Url::to(['/']));
        $menu->ensureContains('Support', [
            'Tickets' => '/ticket/ticket/index',
            'Templates' => '/ticket/template/index',
            'Tickets statistics' => '/ticket/statistic/index',
            'FAQ' => '/faq/faq/index',
        ]);
    }
}




