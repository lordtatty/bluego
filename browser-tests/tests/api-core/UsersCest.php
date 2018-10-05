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
        $I->sendGET($this->buildCallingUrl('/users/get/all'));
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
        $id = $I->grabDataFromResponseByJsonPath('$.data[0].id')[0];
        $I->seeResponseContainsExactJson((object)[
            "links" => (object)[
                "self" => "http://api-core/". $this->instanceName ."/users/add"
            ],
            "data" => [
                (object)[
                    "type" => "users",
                    "id" => $id,
                    "attributes" => (object)[
                    "forename" => "Jim",
                        "surname" => "Biddersdale",
                        "uniqueId" => $id
                    ]
                ]
            ],
            "meta" => (object)[
                "total" => 1
            ]
        ]);
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
        $I->sendGET($this->buildCallingUrl('/users/get/all'));
        $I->seeResponseCodeIs(200);
        $id = $I->grabDataFromResponseByJsonPath('$.data[*].id');
        $I->seeResponseContainsExactJson((object)[
            "links" => (object)[
                "self" => "http://api-core/". $this->instanceName ."/users/get/all"
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

    public function getSingleUser_success(\ApiTester $I)
    {
        $I->amHttpAuthenticated('service_user', '123456');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST($this->buildCallingUrl('/users/add'), [
                'forename' => 'Alice',
                'surname' => 'Crompton'
            ]);

        $I->seeResponseCodeIs(200);
        $id = $I->grabDataFromResponseByJsonPath('$.data[*].id');

        $I->sendGET($this->buildCallingUrl('/users/get/by/id/'.$id[0]));

        $I->seeResponseContainsExactJson((object)[
            "links" => (object)[
                "self" => "http://api-core/". $this->instanceName ."/users/get/by/id/$id[0]"
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
                ]
            ],
            "meta" => (object)[
                "total" => 1
            ]
         ]);
    }

    public function getSingleUser_not_found(\ApiTester $I)
    {
        $userId = 'users:d9187477-6918-4689-ad36-cbecaccf5236';

        $I->sendGET($this->buildCallingUrl('/users/get/by/id/'.$userId));
        $I->seeResponseCodeIs(404);

        $I->seeResponseContainsExactJson((object)[
            "links" => (object)[
                "self" => "http://api-core/". $this->instanceName ."/users/get/by/id/$userId"
            ],
            "data" => [
            ],
            "meta" => (object)[
                "total" => 0
            ]
         ]);
    }

    public function updateUser_success(\ApiTester $I)
    {
        $I->amHttpAuthenticated('service_user', '123456');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST($this->buildCallingUrl('/users/add'), [
                'forename' => 'Jim',
                'surname' => 'Biddersdale'
            ]);
        $I->seeResponseCodeIs(200);
        $id = $I->grabDataFromResponseByJsonPath('$.data[0].id')[0];

        $I->sendPOST($this->buildCallingUrl('/users/update/'.$id), [
                'forename' => 'Tom',
                'surname' => 'Trombone'
            ]);
        $I->seeResponseCodeIs(200);

        $I->seeResponseContainsExactJson((object)[
              "links" => (object)[
                  "self" => "http://api-core/". $this->instanceName ."/users/update/$id"
              ],
              "data" => [
                  (object)[
                      "type" => "users",
                      "id" => $id,
                      "attributes" => (object)[
                          "forename" => "Tom",
                          "surname" => "Trombone",
                          "uniqueId" => $id
                      ]
                  ]
              ],
              "meta" => (object)[
                  "total" => 1
              ]
          ]);
    }

    public function updateUser_not_found(\ApiTester $I)
    {
        $userId = 'users:d9187477-6918-4689-ad36-cbecaccf5236';

        $I->sendPOST($this->buildCallingUrl('/users/update/'.$userId), [
                'forename' => 'Tom',
                'surname' => 'Trombone'
            ]);
        $I->seeResponseCodeIs(404);

        $I->seeResponseContainsExactJson((object)[
                "links" => (object)[
                    "self" => "http://api-core/". $this->instanceName ."/users/update/$userId"
                ],
                "data" => [
                ],
                "meta" => (object)[
                    "total" => 0
                ]
            ]);
    }
}