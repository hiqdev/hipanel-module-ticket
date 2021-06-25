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
    public function createTicket(array $ticket): string
    {
        $I = $this->tester;

        $I->amOnPage(Url::to(['@ticket/create']));

        (new Select2($I, '#thread-topics'))->setValue($ticket['topic']);

        (new Input($I, '#thread-subject'))->setValue($ticket['subject']);
        (new Input($I, '#thread-message'))->setValue($ticket['message']);

        if (isset($ticket['recipient'])) {
            (new Select2($I, '#thread-recipient_id'))->setValue($ticket['recipient']);
        }

        $this->seePreviewWorks($ticket['message']);

        $I->click('Create ticket', '#create-thread-form');
        $this->seeTicketWasCreated($ticket['message'], $ticket['topic']);

        return $I->grabValueFrom(View::THREAD_ID_SELECTOR);
    }

    protected function seePreviewWorks($message): void
    {
        $I = $this->tester;

        $I->click('a[href="#preview-create-thread-form"]');
        $I->waitForText($message, 30, '#preview-create-thread-form');
    }

    protected function seeTicketWasCreated($message, $topic): void
    {
        $I = $this->tester;

        $I->waitForText('Ticket posted', 30);
        $I->seeInCurrentUrl('/ticket/view?id=');
        $I->see($topic);
        $I->see('Close ticket', 'a');
        $I->see($message);
    }
}
