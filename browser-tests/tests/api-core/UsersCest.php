<?php
class CreateUserCest
{
    public function _before(\ApiTester $I)
    {
    }

    public function _after(\ApiTester $I)
    {
    }

    protected function buildCallingUrl($url){
        return '/test' . $url;
    }

    /**
     * @param ApiTester $I
     */
    public function addUser_fails_with_integer_forename(\ApiTester $I)
    {
        $userData = [
            'forename' => 40,
        ];

        $I->amHttpAuthenticated('service_user', '123456');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST($this->buildCallingUrl('/adduser'), $userData);
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
        $I->sendGET($this->buildCallingUrl('/getusers'));
        $I->seeResponseCodeIs(200);
        $I->dontSeeResponseContainsJson([
            '0' => $userData
        ]);
    }

    public function addUser_happy_path(\ApiTester $I)
    {
        $I->amHttpAuthenticated('service_user', '123456');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST($this->buildCallingUrl('/adduser'), [
            'forename' => 'Jim',
            'surname' => 'Biddersdale'
        ]);
        $I->seeResponseCodeIs(200);
        $this->expectUsersJsonApiStructure($I);
//        $I->seeResponseEquals('');
    }

    public function getUsers_happy_path(\ApiTester $I)
    {
        $I->amHttpAuthenticated('service_user', '123456');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET($this->buildCallingUrl('/getusers'));
        $I->seeResponseCodeIs(200);
        $this->expectUsersJsonApiStructure($I);
        $I->seeResponseContainsJson([
                'forename' => 'Jim',
                'surname' => 'Biddersdale'
        ]);

    }

    protected function expectUsersJsonApiStructure(\ApiTester $I) {
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$.links.self');
        $I->seeResponseJsonMatchesJsonPath('$.data[*].type');
        $I->seeResponseJsonMatchesJsonPath('$.data[*].id');
        $I->seeResponseJsonMatchesJsonPath('$.data[*].attributes.forename');
        $I->seeResponseJsonMatchesJsonPath('$.data[*].attributes.surname');
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
                                                       'forename' => 'string',
                                                       'surname' => 'string',
                                                   ]
                                               ]
                                           ],
                                           'meta' => [
                                               'total' => 'integer'
                                           ]
                                       ]);
    }
}