<?php
class WebYiiHomepageCest
{    
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
    }

    public function canSeeWelcomeMessage(AcceptanceTester $I)
    {
        // write a positive login test
        $I->seeInPageSource('Get started with Yii');
//        $I->canSee('awesome');
    }
}