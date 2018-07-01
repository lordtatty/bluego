<?php
class ApiCoreHomepageCest
{    
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
    }

    public function canSeeWelcomeMessage(AcceptanceTester $I)
    {
        // write a positive login test
        $I->seeInPageSource('Slim');
//        $I->canSee('awesome');
    }

}