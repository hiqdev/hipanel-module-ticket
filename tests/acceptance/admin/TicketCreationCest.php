<?php

namespace hipanel\modules\ticket\tests\acceptance\Seller;

use hipanel\helpers\Url;
use Codeception\Example;
use hipanel\tests\_support\Step\Acceptance\Admin;
use hipanel\modules\ticket\tests\_support\Page\ticket\Create;
use hipanel\modules\ticket\tests\_support\Page\ticket\Index;
use hipanel\modules\ticket\tests\_support\Page\ticket\View;

class TicketCreationCest
{
    private string $ticketId;

    /**
     * @dataProvider provideTicketData
     */
    public function ensureICanCreateTicket(Admin $I, Example $example): void
    {
        $I->login();

        $this->ticketId = $this->createTicket($I, $example);
        $this->ensureISeeCreatedTicketOnIndexPage($I);
        $this->ensureICanCommentTicket($I);
    }

    private function createTicket(Admin $I, Example $exampleTicket): ?string 
    {
        $createPage = new Create($I);

        $exampleArray = iterator_to_array($exampleTicket->getIterator());
        return $createPage->createTicket($exampleArray);
    }

    private function ensureISeeCreatedTicketOnIndexPage(Admin $I): void
    {
        $index = new Index($I);

        $index->hasLinkToTicket($this->ticketId);
    }

    private function ensureICanCommentTicket(Admin $I): void
    {
        $view = new View($I, $this->ticketId);

        $view->visitTicket();
        $view->postComment('This is a test comment. Ignore it, please.');
    }

    private function provideTicketData(): array
    {
        return [
            'ticket' => [
                'subject' => uniqid(),
                'message' => 'someone abuses uniqid ' . uniqid(),
                'topic'   => 'Abuse',
                'recipient' => 'hipanel_test_admin',
            ],
        ];
    }
}
