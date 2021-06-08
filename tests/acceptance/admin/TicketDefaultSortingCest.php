<?php

namespace hipanel\modules\ticket\tests\acceptance\admin;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Step\Acceptance\Admin;

class TicketDefaultSortingCest
{
    public function ensureDefaultStatusIsCorrect(Admin $I)
    {
        $I->login();
        $I->needPage(Url::to('@ticket/index'));
        $I->see('Show all', "span[id*='select2-threadsearch-state-']");
    }
}
