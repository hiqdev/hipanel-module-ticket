<?php

namespace hipanel\modules\ticket\tests\acceptance\client;

use hipanel\tests\_support\Page\SidebarMenu;
use hipanel\tests\_support\Step\Acceptance\Client;
use yii\helpers\Url;

class TicketSidebarMenuCest
{
    public function ensureMenuIsOk(Client $I)
    {
        $I->login();
        $menu = new SidebarMenu($I);

        $I->amOnPage(Url::to(['/']));
        $menu->ensureContains('Support', [
            'Tickets' => '/ticket/ticket/index',
            'FAQ' => '/faq/faq/index',
        ]);

        $I->amOnPage(Url::to(['/']));
        $menu->ensureDoesNotContain('Support', [
            'Templates',
            'Tickets statistics',
        ]);
    }
}
