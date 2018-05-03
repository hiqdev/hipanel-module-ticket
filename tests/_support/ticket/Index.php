<?php

namespace hipanel\modules\ticket\tests\_support\ticket;

use hipanel\tests\_support\Page\Authenticated;
use yii\helpers\Url;

/**
 * Class Index
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class Index extends Authenticated
{
    public function ensurePageWorks()
    {
        $I = $this->tester;
        $I->amOnPage(Url::to(['@ticket']));

        $I->performOnContent(\Codeception\Util\ActionSequence::build()
            ->see('Create ticket')
        );

        return $this;
    }

    public function ensureThatICanNavigateToCreateTicketPage()
    {
        $I = $this->tester;

        $I->amOnPage(Url::to(['@ticket']));

        $I->click('Create ticket', '.content-wrapper');

        $I->waitForElement('#create-thread-form');
        $I->see('Topics');
        $I->see('Subject');
        $I->see('Create ticket', 'button');

        return $this;
    }

    public function hasLinkToTicket($id)
    {
        $I = $this->tester;

        $I->amOnPage(Url::to(['@ticket']));
        $I->seeElement('tr', ['data-key' => $id]);

        return $this;
    }

    public function hasntLinkToTicket($id)
    {
        $I = $this->tester;

        $I->amOnPage(Url::to(['@ticket']));
        $I->dontSeeElement('tr', ['data-key' => $id]);

        return $this;
    }
}
