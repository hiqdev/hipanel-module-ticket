<?php

namespace hipanel\modules\ticket\tests\acceptance\client;

use Codeception\Scenario;
use hipanel\helpers\Url;
use Codeception\Example;
use hipanel\modules\ticket\tests\_support\Page\ticket\Create;
use hipanel\modules\ticket\tests\_support\Page\ticket\Index;
use hipanel\modules\ticket\tests\_support\Page\ticket\View;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Step\Acceptance\Client;

/**
 * Class TicketCest
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class TicketCest
{
    /**
     * @var string|int
     */
    protected $ticket_id;

    private IndexPage $index;

    public function _before(Client $I): void
    {
        $this->index = new IndexPage($I);
    }

    public function ensureIndexPageWorks(Client $I): void
    {
        $I->login();
        $I->needPage(Url::to('@ticket'));
        $I->see('Tickets', 'h1');
        $I->seeLink('Create ticket', Url::to('@ticket/create'));
        $this->ensureICanSeeAdvancedSearchBox($I);
        $this->ensureICanSeeBulkSearchBox();
        (new Index($I))->ensurePageWorks();
    }

    private function ensureICanSeeAdvancedSearchBox(Client $I): void
    {
        $this->index->containsFilters([
            Input::asAdvancedSearch($I, 'Subject or 1st message'),
            Select2::asAdvancedSearch($I, 'Status'),
            Select2::asAdvancedSearch($I, 'Topics'),
        ]);
    }

    private function ensureICanSeeBulkSearchBox(): void
    {
        $this->index->containsBulkButtons([
            'Close',
        ]);
        $this->index->containsColumns([
            'Subject',
            'Answers',
        ]);
    }

    public function ensureICanNavigateToCreateTicketPage(Client $I): void
    {
        (new Index($I))->ensureThatICanNavigateToCreateTicketPage();
    }

    /**
     * @dataProvider provideDataTicket
     */
    public function ensureICanCreateTicket(Client $I, Example $example): void
    {
        $ticketData = iterator_to_array($example->getIterator());
        $this->ticket_id = (new Create($I))->createTicket($ticketData);
    }

    public function ensureISeeCreatedTicketOnIndexPage(Client $I, Scenario $scenario): void
    {
        if (!isset($this->ticket_id)) {
            $scenario->incomplete('Ticket ID must be filled to run this test');
        }

        $index = new Index($I);
        $index->hasLinkToTicket($this->ticket_id);
    }

    public function ensureICanCommentTicket(Client $I, Scenario $scenario): void
    {
        if (!isset($this->ticket_id)) {
            $scenario->incomplete('Ticket ID must be filled to run this test');
        }

        $view = new View($I, $this->ticket_id);
        $view->visitTicket();
        $view->postComment('This is a test comment. Ignore it, please.');
    }

    public function ensureICanChangeTicketState(Client $I, Scenario $scenario): void
    {
        if (!isset($this->ticket_id)) {
            $scenario->incomplete('Ticket ID must be filled to run this test');
        }

        $view = new View($I, $this->ticket_id);
        $view->visitTicket();
        $view->closeTicket();

        $I->openNewTab();
        $index = new Index($I);
        $index->ensureTicketClosed($this->ticket_id);
        $I->closeTab();

        $view->openTicket();
        $view->closeTicket();
    }
    
    protected function provideDataTicket(): array
    {
        return [
            'ticket' => [
                'subject'   => 'Test ticket (' . date('Y-m-d H:i') . ')',
                'message'   => 'This is a test ticket created by automated testing system. Ignore it, please.',
                'topic'     => 'VDS',
            ],
        ];
    }
}
