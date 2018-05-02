<?php

namespace hipanel\modules\ticket\tests\acceptance\client;

use Codeception\Scenario;
use hipanel\modules\ticket\tests\_support\ticket\Create;
use hipanel\modules\ticket\tests\_support\ticket\Index;
use hipanel\modules\ticket\tests\_support\ticket\View;
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

    public function ensureIndexPageWorks(Client $I)
    {
        (new Index($I))->ensurePageWorks();
    }

    public function ensureICanNavigateToCreateTicketPage(Client $I)
    {
        (new Index($I))->ensureThatICanNavigateToCreateTicketPage();
    }

    public function ensureICanCreateTicket(Client $I)
    {
        $this->ticket_id = (new Create($I))->createTicket(
            'Test ticket (' . date('Y-m-d H:i') . ')',
            'This is a test ticket created by automated testing system. Ignore it, please.',
            'General question'
        );
    }

    public function ensureISeeCreatedTicketOnIndexPage(Client $I, Scenario $scenario)
    {
        if (!isset($this->ticket_id)) {
            $scenario->incomplete('Ticket ID must be filled to run this test');
        }

        $index = new Index($I);
        $index->hasLinkToTicket($this->ticket_id);
    }

    public function ensureICanCommentTicket(Client $I, Scenario $scenario)
    {
        if (!isset($this->ticket_id)) {
            $scenario->incomplete('Ticket ID must be filled to run this test');
        }

        $view = new View($I, $this->ticket_id);
        $view->visitTicket();
        $view->postComment('This is a test comment. Ignore it, please.');
    }

    public function ensureICanChangeTicketState(Client $I, Scenario $scenario)
    {
        if (!isset($this->ticket_id)) {
            $scenario->incomplete('Ticket ID must be filled to run this test');
        }

        $view = new View($I, $this->ticket_id);
        $view->visitTicket();
        $view->closeTicket();

        $I->openNewTab();
        $index = new Index($I);
        $index->hasntLinkToTicket($this->ticket_id);
        $I->closeTab();

        $view->openTicket();
        $view->closeTicket();
    }
}
