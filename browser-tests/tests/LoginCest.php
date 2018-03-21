<?php
class LoginCest 
{    
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
    }

    public function loginSuccessfully(AcceptanceTester $I)
    {
        // write a positive login test
        $I->seeInPageSource('awesome2');
//        $I->canSee('awesome');
    }
    
    public function loginWithInvalidPassword(AcceptanceTester $I)
    {
        // write a negative login test
    }       
}