<?php
class CreateUserCest
{
    public function _before(\ApiTester $I)
    {
    }

    public function _after(\ApiTester $I)
    {
    }

    // tests
    public function getUsers(\ApiTester $I)
    {
        $I->amHttpAuthenticated('service_user', '123456');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGET('/getusers');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$[0].name');
        $I->seeResponseJsonMatchesJsonPath('$[0].age');
        $I->dontSeeResponseJsonMatchesJsonPath('$[0]._id');
        $I->seeResponseContainsJson([
            '0' => [
                'name' => 'Bob',
                'age' => '40'
            ]
        ]);
        $I->seeResponseMatchesJsonType([
           'name' => 'string',
           'age' => 'integer'
       ]);
    }
}