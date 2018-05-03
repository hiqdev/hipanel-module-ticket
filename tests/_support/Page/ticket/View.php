<?php

namespace hipanel\modules\ticket\tests\_support\Page\ticket;

use hipanel\tests\_support\AcceptanceTester;
use hipanel\tests\_support\Page\Authenticated;
use yii\helpers\Url;

/**
 * Class View
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class View extends Authenticated
{
    const THREAD_ID_SELECTOR = '.leave-comment-form input[name="Thread[id]"]';

    /**
     * @var string|int
     */
    private $ticketId;

    /**
     * View constructor.
     * @param \AcceptanceTester $I
     * @param string|int $ticketId
     */
    public function __construct(AcceptanceTester $I, $ticketId)
    {
        parent::__construct($I);

        $this->ticketId = $ticketId;
    }

    public function visitTicket()
    {
        $I = $this->tester;

        $I->amOnPage(Url::to(['@ticket/view', 'id' => $this->ticketId]));
        $I->seeInField(self::THREAD_ID_SELECTOR, $this->ticketId);

        return $this;
    }

    public function postComment($message)
    {
        $I = $this->tester;

        $I->fillField('#thread-message', $message);
        $this->seePreviewWorks($message);

        $I->click('Answer', '#leave-comment-form');
        $I->waitForText('Ticket changed');
        $this->seePageContainsComment($message);
    }

    protected function seePreviewWorks($message)
    {
        $I = $this->tester;

        $I->click('a[href="#preview-leave-comment-form"]');
        $I->waitForText($message, 10, '#preview-leave-comment-form');
    }

    protected function seePageContainsComment($message)
    {
        $I = $this->tester;

        $I->see($message, '.comment .comment-text .body');
    }

    public function closeTicket()
    {
        $I = $this->tester;

        $I->see('Close ticket');
        $I->click('Close ticket');
        $I->waitForText('Ticket closed');
        $I->waitForText('Open ticket', 3);
    }

    public function openTicket()
    {
        $I = $this->tester;

        $I->see('Open ticket');
        $I->click('Open ticket');
        $I->waitForText('Ticket opened');
        $I->waitForText('Close ticket', 3);
    }
}
