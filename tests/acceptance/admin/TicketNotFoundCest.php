<?php

namespace hipanel\modules\ticket\tests\acceptance\admin;

use hipanel\tests\_support\Step\Acceptance\Admin;
use yii\helpers\Url;

class TicketNotFoundCest
{
    public function ensureISeeNotFoundErrorPageWhenRequestNotExistentTicketId(Admin $I)
    {
        $I->login();
        $I->amOnPage(Url::to(['@ticket/view', 'id' => '11111111111111']));
        $I->seeInTitle('Not Found (#404)');
    }
}
