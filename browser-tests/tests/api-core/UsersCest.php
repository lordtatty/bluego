<?php
class UsersCest
{
    protected $instanceName;
    protected $usedInstanceNames = [];
    public function _before(\ApiTester $I)
    {
        do {
            $this->instanceName =  uniqid('BlueGoTest_');
        } while(isset($this->usedInstanceNames[$this->instanceName]));
        $this->usedInstanceNames[$this->instanceName] = true;
    }

    public function _after(\ApiTester $I)
    {
    }

    protected function buildCallingUrl($url){
        return '/' . $this->instanceName . $url;
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
        $I->sendPOST($this->buildCallingUrl('/users/add'), $userData);
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
        $I->sendGET($this->buildCallingUrl('/users/getall'));
        $I->seeResponseCodeIs(200);
        $I->dontSeeResponseContainsJson([
            '0' => $userData
        ]);
    }

    public function addUser_happy_path(\ApiTester $I)
    {
        $I->amHttpAuthenticated('service_user', '123456');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST($this->buildCallingUrl('/users/add'), [
            'forename' => 'Jim',
            'surname' => 'Biddersdale'
        ]);
        $I->seeResponseCodeIs(200);
        $this->expectUsersJsonApiStructure($I);
        $id = $I->grabDataFromResponseByJsonPath('$.data[0].id')[0];
        $I->seeResponseEquals(json_encode([
            "links" => [
                "self" => "http://api-core/". $this->instanceName ."/users/add"
            ],
            "data" => [
                [
                    "type" => "users",
                    "id" => $id,
                    "attributes" => [
                    "forename" => "Jim",
                        "surname" => "Biddersdale",
                        "uniqueId" => $id
                    ]
                ]
            ],
            "meta" => [
                "total" => 1
            ]
        ]));
    }

    public function getUsers_happy_path(\ApiTester $I)
    {
        $I->amHttpAuthenticated('service_user', '123456');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST($this->buildCallingUrl('/users/add'), [
                'forename' => 'Alice',
                'surname' => 'Crompton'
            ]);

        $I->sendPOST($this->buildCallingUrl('/users/add'), [
                'forename' => 'Jim',
                'surname' => 'Biddersdale'
            ]);
        $I->sendGET($this->buildCallingUrl('/users/getall'));
        $I->seeResponseCodeIs(200);
        $this->expectUsersJsonApiStructure($I);
        $id = $I->grabDataFromResponseByJsonPath('$.data[*].id');
        $I->seeResponseContainsExactJson((object)[
            "links" => (object)[
                "self" => "http://api-core/". $this->instanceName ."/users/getall"
            ],
            "data" => [
                (object)[
                    "type" => "users",
                    "id" => $id[0],
                    "attributes" => (object)[
                        "forename" => "Alice",
                        "surname" => "Crompton",
                        "uniqueId" => $id[0]
                    ],
                ],
                (object)[
                    "type" => "users",
                    "id" => $id[1],
                    "attributes" => (object)[
                        "forename" => "Jim",
                        "surname" => "Biddersdale",
                        "uniqueId" => $id[1]
                    ]
                ]
            ],
            "meta" => (object)[
                "total" => 2
            ]
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