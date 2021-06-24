<?php

namespace hipanel\modules\ticket\tests\acceptance\admin;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Step\Acceptance\Admin;

class TicketCest
{
    private IndexPage $index;

    public function _before(Admin $I): void
    {
        $this->index = new IndexPage($I);
    }

    public function ensureIndexPageWorks(Admin $I): void
    {
        $I->login();
        $I->needPage(Url::to('@ticket/index'));
        $I->see('Tickets', 'h1');
        $I->seeLink('Create ticket', Url::to('@ticket/create'));
        $this->ensureICanSeeAdvancedSearchBox($I);
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox(Admin $I): void
    {
        $this->index->containsFilters([
            Input::asAdvancedSearch($I, 'Subject or 1st message'),
            Input::asAdvancedSearch($I, 'Message'),
            Input::asAdvancedSearch($I, 'Ticket numbers separated by commas'),
            Select2::asAdvancedSearch($I, 'Author'),
            Select2::asAdvancedSearch($I, 'Recipient'),
            Select2::asAdvancedSearch($I, 'Status'),
            Select2::asAdvancedSearch($I, 'Assignee'),
            Select2::asAdvancedSearch($I, 'Priority'),
            Select2::asAdvancedSearch($I, 'Watchers'),
            Select2::asAdvancedSearch($I, 'Topics'),
        ]);
    }

    private function ensureICanSeeBulkSearchBox(): void
    {
        $this->index->containsBulkButtons([
            'Subscribe',
            'Unsubscribe',
            'Close',
        ]);
        $this->index->containsColumns([
            'Subject',
            'Author',
            'Assignee',
            'Recipient',
            'Answers',
        ]);
    }
}
