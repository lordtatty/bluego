<?php
class CreateUserCest
{
    public function _before(\ApiTester $I)
    {
    }

    public function _after(\ApiTester $I)
    {
    }

    /**
     * @param ApiTester $I
     */
    public function addUser_fails_with_integer_aname(\ApiTester $I)
    {
        $userData = [
            'name' => 40,
        ];

        $I->amHttpAuthenticated('service_user', '123456');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/adduser', $userData);
        $I->seeResponseCodeIs(500);
        $I->seeResponseEquals(json_encode([
            'errors' => [
                [
                    'code' => 500,
                    'title' => "Internal server error"
                ]
            ]
        ]));

        // Ensure User does not exist
        $I->sendGET('/getusers');
        $I->seeResponseCodeIs(200);
        $I->dontSeeResponseContainsJson([
            '0' => $userData
        ]);
    }

    public function addUser_happy_path(\ApiTester $I)
    {
        $I->amHttpAuthenticated('service_user', '123456');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/adduser', [
            'name' => 'Jim',
        ]);
        $I->seeResponseCodeIs(200);
        $this->expectUsersJsonApiStructure($I);
//        $I->seeResponseEquals('');
    }

    public function getUsers_happy_path(\ApiTester $I)
    {
        $I->amHttpAuthenticated('service_user', '123456');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('/getusers');
        $I->seeResponseCodeIs(200);
        $this->expectUsersJsonApiStructure($I);
        $I->seeResponseContainsJson([
                'name' => 'Jim',
        ]);

    }

    protected function expectUsersJsonApiStructure(\ApiTester $I) {
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$.links.self');
        $I->seeResponseJsonMatchesJsonPath('$.data[*].type');
        $I->seeResponseJsonMatchesJsonPath('$.data[*].id');
        $I->seeResponseJsonMatchesJsonPath('$.data[*].attributes.name');
        $I->seeResponseJsonMatchesJsonPath('$.meta.total');
        $I->dontSeeResponseJsonMatchesJsonPath('$.data[*].attributes._id');
        $I->seeResponseMatchesJsonType([
                                           'links' => [
                                               'self' => 'string'
                                           ],
                                           'data' => [
                                               [
                                                   'type' => 'string',
                                                   'id' => 'string',
                                                   'attributes' => [
                                                       'name' => 'string',
                                                   ]
                                               ]
                                           ],
                                           'meta' => [
                                               'total' => 'integer'
                                           ]
                                       ]);
    }
}