<?php

namespace hipanel\modules\ticket\tests\acceptance\seller;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Step\Acceptance\Seller;

class TicketStatisticsCest
{
    /**
     * @var IndexPage
     */
    private $index;

    public function _before(Seller $I)
    {
        $this->index = new IndexPage($I);
    }

    public function ensureIndexPageWorks(Seller $I)
    {
        $I->login();
        $I->needPage(Url::to('/ticket/statistic'));
        $I->see('Tickets statistics', 'h1');
        $I->seeLink('Create ticket', Url::to('@ticket/create'));
        $this->ensureICanSeeAdvancedSearchBox();
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox()
    {
        $this->index->containsFilters([
            new Input('Anytext'),
            new Select2('Author'),
            new Select2('Recipient'),
            new Select2('Status'),
            new Select2('Assignee'),
            new Select2('Priority'),
            new Select2('Watchers'),
            new Input('Topics'),
        ]);
    }

    private function ensureICanSeeBulkSearchBox()
    {
        $this->index->containsColumns([
            'Client',
            'Spent',
            'Tickets',
        ]);
    }
}
