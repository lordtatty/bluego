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

    public function add_course_happy_path(\ApiTester $I)
    {
        $I->amHttpAuthenticated('service_user', '123456');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST($this->buildCallingUrl('/courses/add'), [
            'title' => 'Course 1',
            'course_code' => 'course_1'
        ]);
        $I->seeResponseCodeIs(200);
        $id = $I->grabDataFromResponseByJsonPath('$.data[0].id')[0];
        $I->seeResponseContainsExactJson((object)[
            "links" => (object)[
                "self" => "http://api-core/". $this->instanceName ."/courses/add"
            ],
            "data" => [
                (object)[
                    "type" => "courses",
                    "id" => $id,
                    "attributes" => (object)[
                        "title" => "Course 1",
                        "course_code" => "course_1",
                        "uniqueId" => $id
                    ]
                ]
            ],
            "meta" => (object)[
                "total" => 1
            ]
        ]);
    }

    public function get_all_courses_happy_path(\ApiTester $I)
    {
        $I->amHttpAuthenticated('service_user', '123456');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST($this->buildCallingUrl('/courses/add'), [
                'title' => 'Course 1',
                'course_code' => 'course_1'
            ]);

        $I->sendPOST($this->buildCallingUrl('/courses/add'), [
                'title' => 'Course 2',
                'course_code' => 'course_2'
            ]);
        $I->sendGET($this->buildCallingUrl('/courses/get/all'));
        $I->seeResponseCodeIs(200);
        $id = $I->grabDataFromResponseByJsonPath('$.data[*].id');
        $I->seeResponseContainsExactJson((object)[
            "links" => (object)[
                "self" => "http://api-core/". $this->instanceName ."/courses/get/all"
            ],
            "data" => [
                (object)[
                    "type" => "courses",
                    "id" => $id[0],
                    "attributes" => (object)[
                        'title' => 'Course 1',
                        'course_code' => 'course_1',
                        "uniqueId" => $id[0]
                    ],
                ],
                (object)[
                    "type" => "courses",
                    "id" => $id[1],
                    "attributes" => (object)[
                        'title' => 'Course 2',
                        'course_code' => 'course_2',
                        "uniqueId" => $id[1]
                    ]
                ]
            ],
            "meta" => (object)[
                "total" => 2
            ],
         ]);
    }

}