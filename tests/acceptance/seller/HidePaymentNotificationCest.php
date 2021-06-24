<?php 

namespace hipanel\modules\ticket\tests\acceptance\seller;

use hipanel\helpers\Url;
use hipanel\tests\_support\Step\Acceptance\Seller;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Page\IndexPage;

class HidePaymentNotificationCest
{
    private IndexPage $index;

    public function _before(Seller $I): void
    {
        $this->index = new IndexPage($I);
    }

    public function enusreICanHidePaymentNotification(Seller $I): void
    {
        $I->login();
        $I->needPage(Url::to('@ticket/index'));
        $this->setFilters($I);
        $I->click('Search');
        $I->waitForPageUpdate();
        $this->ensureICantSeePaymentTickets($I);
    }

    private function setFilters(Seller $I): void
    {
        (new Select2($I, "div[class*='topics'] select"))->setValue('Payment');
        $I->checkOption('#threadsearch-hide_payment');
    }

    private function ensureICantSeePaymentTickets(Seller $I): void
    {
        $I->see('Payment', "//span[@class='label label-default']");
    }
}
