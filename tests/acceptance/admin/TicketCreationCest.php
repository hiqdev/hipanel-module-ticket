<?php

namespace hipanel\modules\ticket\tests\acceptance\Seller;

use hipanel\helpers\Url;
use Codeception\Example;
use hipanel\tests\_support\Step\Acceptance\Admin;
use hipanel\modules\ticket\tests\_support\Page\ticket\Create;

class TicketStatisticsCest
{
    /**
     * @dataProvider provideTicketData
     */
    public function ensureICanCreateTicket(Admin $I, Example $example)
    {
        $I->login();
        $this->fillMainTicketFields($I, $example);
    }

    private function fillMainTicketFields(Admin $I,Example $exampleTicket)
    {
        $createPage = new Create($I);
        $exampleArray = iterator_to_array($exampleTicket->getIterator());
        $createPage->createTicket($exampleArray);
    }

    private function provideTicketData(): array
    {
        return [
            'ticket' => [
                'subject' => uniqid(),
                'message' => 'someone abuses uniqid ' . uniqid(),
                'topic'   => [
                    'topics'   => 'Abuse',
                    'reciever' => 'hipanel_test_admin',
                ],
            ],
        ];
    }
}
