<?php 

namespace hipanel\modules\ticket\tests\acceptance\seller;

use hipanel\helpers\Url;
use hipanel\tests\_support\Step\Acceptance\Seller;
use hipanel\tests\_support\Page\IndexPage;

class HidePaymentNotificationCest
{
    /**
     * @var IndexPage
     */
    private $index;

    public function _before(Seller $I)
    {
        $this->index = new IndexPage($I);
    }

    public function enusreICanHidePaymentNotification(Seller $I)
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
        $I->checkOption('#threadsearch-hide_payment');
    }

    private function ensureICantSeePaymentTickets(Seller $I)
    {
        $rowCount = $this->index->countRowsInTableBody();
        for ($currentRow = 1; $currentRow < $rowCount; $currentRow++) {
            $I->dontSee('Payment', "//tbody//tr[$currentRow]//li//span");
        }
    }
}
