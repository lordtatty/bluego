<?php
class WebApacheHomepageCest
{    
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
    }

    public function canSeeWelcomeMessage(AcceptanceTester $I)
    {
        // write a positive login test
        $I->seeInPageSource('awesome');
//        $I->canSee('awesome');
    }

}