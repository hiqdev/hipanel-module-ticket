<?php

namespace hipanel\modules\ticket\tests\_support\Page\ticket;

use hipanel\tests\_support\Page\Authenticated;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use yii\helpers\Url;

/**
 * Class Create
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class Create extends Authenticated
{
    public function createTicket($ticketData)
    {
        $I = $this->tester;

        $I->amOnPage(Url::to(['@ticket/create']));

        $topic = $ticketData['topic']['topics'];
        (new Select2($I, '#thread-topics'))->setValue($ticketData['topic']['topics']);
        (new Select2($I, '#thread-recipient_id'))->setValue($ticketData['topic']['reciever']);


        (new Input($I, '#thread-subject'))->setValue($ticketData['subject']);
        (new Input($I, '#thread-message'))->setValue($ticketData['message']);

        $this->seePreviewWorks($ticketData['message']);

        $I->click('Create ticket', '#create-thread-form');
        $this->seeTicketWasCreated($ticketData['message'], $topic);

        return $I->grabValueFrom(View::THREAD_ID_SELECTOR);
    }

    protected function seePreviewWorks($message)
    {
        $I = $this->tester;

        $I->click('a[href="#preview-create-thread-form"]');
        $I->waitForText($message, 30, '#preview-create-thread-form');
    }

    protected function seeTicketWasCreated($message, $topic)
    {
        $I = $this->tester;

        $I->waitForText('Ticket posted', 30);
        $I->seeInCurrentUrl('/ticket/view?id=');
        $I->see($topic);
        $I->see('Close ticket', 'a');
        $I->see($message);
    }
}
