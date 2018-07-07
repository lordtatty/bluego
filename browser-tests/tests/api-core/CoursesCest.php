<?php
class CoursesCest
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

//    /**
//     * @param ApiTester $I
//     */
//    public function addUser_fails_with_integer_forename(\ApiTester $I)
//    {
//        $userData = [
//            'forename' => 40,
//        ];
//
//        $I->amHttpAuthenticated('service_user', '123456');
//        $I->haveHttpHeader('Content-Type', 'application/json');
//        $I->sendPOST($this->buildCallingUrl('/adduser'), $userData);
//        $I->seeResponseCodeIs(500);
//        $I->seeResponseEquals(json_encode([
//            'errors' => [
//                [
//                    'code' => 500,
//                    'title' => "Internal server error"
//                ]
//            ]
//        ]));
//
//        // Ensure User does not exist
//        $I->sendGET($this->buildCallingUrl('/getusers'));
//        $I->seeResponseCodeIs(200);
//        $I->dontSeeResponseContainsJson([
//            '0' => $userData
//        ]);
//    }

    public function add_course_happy_path(\ApiTester $I)
    {
        $I->amHttpAuthenticated('service_user', '123456');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST($this->buildCallingUrl('/addcourse'), [
            'title' => 'Course 1',
            'course_code' => 'course_1'
        ]);
        $I->seeResponseCodeIs(200);
        $this->expectUsersJsonApiStructure($I);
        $id = $I->grabDataFromResponseByJsonPath('$.data[0].id')[0];
        $I->seeResponseEquals(json_encode([
            "links" => [
                "self" => "http://api-core/". $this->instanceName ."/addcourse"
            ],
            "data" => [
                [
                    "type" => "courses",
                    "id" => $id,
                    "attributes" => [
                        "title" => "Course 1",
                        "course_code" => "course_1",
                        "uniqueId" => $id
                    ]
                ]
            ],
            "meta" => [
                "total" => 1
            ]
        ]));
    }

//    public function getUsers_happy_path(\ApiTester $I)
//    {
//        $I->amHttpAuthenticated('service_user', '123456');
//        $I->haveHttpHeader('Content-Type', 'application/json');
//        $I->sendPOST($this->buildCallingUrl('/adduser'), [
//                'forename' => 'Alice',
//                'surname' => 'Crompton'
//            ]);
//
//        $I->sendPOST($this->buildCallingUrl('/adduser'), [
//                'forename' => 'Jim',
//                'surname' => 'Biddersdale'
//            ]);
//        $I->sendGET($this->buildCallingUrl('/getusers'));
//        $I->seeResponseCodeIs(200);
//        $this->expectUsersJsonApiStructure($I);
//        $id = $I->grabDataFromResponseByJsonPath('$.data[*].id');
//        $I->seeResponseEquals(json_encode([
//            "links" => [
//                "self" => "http://api-core/". $this->instanceName ."/getusers"
//            ],
//            "data" => [
//                [
//                    "type" => "users",
//                    "id" => $id[0],
//                    "attributes" => [
//                        "forename" => "Alice",
//                        "surname" => "Crompton",
//                        "uniqueId" => $id[0]
//                    ],
//                ],
//                [
//                    "type" => "users",
//                    "id" => $id[1],
//                    "attributes" => [
//                        "forename" => "Jim",
//                        "surname" => "Biddersdale",
//                        "uniqueId" => $id[1]
//                    ]
//                ]
//            ],
//            "meta" => [
//                "total" => 2
//            ]
//         ]));
//
//    }

    protected function expectUsersJsonApiStructure(\ApiTester $I) {
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$.links.self');
        $I->seeResponseJsonMatchesJsonPath('$.data[*].type');
        $I->seeResponseJsonMatchesJsonPath('$.data[*].id');
        $I->seeResponseJsonMatchesJsonPath('$.data[*].attributes.title');
        $I->seeResponseJsonMatchesJsonPath('$.data[*].attributes.course_code');
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
                                                       'title' => 'string',
                                                       'course_code' => 'string',
                                                   ]
                                               ]
                                           ],
                                           'meta' => [
                                               'total' => 'integer'
                                           ]
                                       ]);
    }
}