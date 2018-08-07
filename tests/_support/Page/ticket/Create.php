<?php

namespace hipanel\modules\ticket\tests\_support\Page\ticket;

use hipanel\tests\_support\AcceptanceTester;
use hipanel\tests\_support\Page\Authenticated;
use hipanel\tests\_support\Page\Widget\Select2;
use yii\helpers\Url;

/**
 * Class Create
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class Create extends Authenticated
{
    /**
     * @var Select2
     */
    protected $select2;

    public function __construct(AcceptanceTester $I)
    {
        parent::__construct($I);

        $this->select2 = new Select2($I);
    }

    public function createTicket($subject, $message, $topic)
    {
        $I = $this->tester;

        $I->amOnPage(Url::to(['@ticket/create']));

        $this->select2->open('#thread-topics');
        $I->see('General question');
        $I->see('Financial question');
        $I->see('VDS');

        $this->select2->chooseOption($topic);

        $I->fillField('#thread-subject', $subject);
        $I->fillField('#thread-message', $message);
        $this->seePreviewWorks($message);

        $I->click('Create ticket', '#create-thread-form');
        $this->seeTicketWasCreated($message, $topic);

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
