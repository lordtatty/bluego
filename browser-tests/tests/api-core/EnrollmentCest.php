<?php
class EnrollmentCest
{
    protected $instanceName;
    protected $usedInstanceNames = [];
    public function _before(\ApiTester $I)
    {
        do {
            $this->instanceName =  uniqid('BlueGoTest_' . __CLASS__ . '_');
        } while(isset($this->usedInstanceNames[$this->instanceName]));
        $this->usedInstanceNames[$this->instanceName] = true;
        $I->setApiInstance($this->instanceName);
    }

    public function _after(\ApiTester $I)
    {
    }

    /**
     * In this test we will do the following:
     *
     *   - Create two users
     *   - Create two courses
     *
     *   - Add user1 to course1
     *     - Ensure views show user1 on course1
     *     - Ensure views show user1 not on course2
     *     - Ensure views show user2 not on any course
     *
     *   - Add user2 to course 2
     *     - Ensure views show user1 and 2 on course1
     *     - Ensure views show nobody on course 2
     *
     *   - Add user1 to course 2
     *     - Ensure views show user1 on course1 and course2
     *     - Ensure views show user2 on course1
     *     - Ensure views show user2 not on course2
     *
     *   - Update user data for user1
     *     - Ensure views show updatedUser1 on course1 and course2
     *     - Ensure views show user2 on course1
     *     - Ensure views show user2 not on course2
     *
     * @param ApiTester $I
     */
    public function enroll_user_to_course_builds_views(\ApiTester $I){
        $userData1 = [
            'forename' => 'Jane',
            'surname' => 'Awesome',
        ];
        $userData2 = [
            'forename' => 'Danny',
            'surname' => 'Cool',
        ];
        $courseData1 = [
            'title' => 'Course 1',
            'course_code' => 'course_1'
        ];
        $courseData2 = [
            'title' => 'Course 1',
            'course_code' => 'course_1'
        ];
        $I->amHttpAuthenticated('service_user', '123456');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->addNewUser($userData1);
        $userId1 = $I->grabDataFromResponseByJsonPath('$.data[0].id')[0];
        $I->addNewUser($userData2);
        $userId2 = $I->grabDataFromResponseByJsonPath('$.data[0].id')[0];
        $I->addCourse($courseData1);
        $courseId1 = $I->grabDataFromResponseByJsonPath('$.data[0].id')[0];
        $I->addCourse($courseData2);
        $courseId2 = $I->grabDataFromResponseByJsonPath('$.data[0].id')[0];

        // Enroll just one user and check the views
        $this->enrollSingleUser($I, $courseId1, $userId1);

        $this->checkCourseUsersView($I, $courseId1, [
                $userId1 => $userData1
            ]);
        $this->checkCourseUsersView($I, $courseId2, [
            ]); // Nobody should be on this course
        $this->checkUserCoursesView($I, $userId1, [
                $courseId1 => $courseData1
            ]);
        $this->checkUserCoursesView($I, $userId2, [
            ]); // This user should not be enrolled

        // Enroll a Second user and check the views
        $this->enrollSingleUser($I, $courseId1, $userId2);
        $this->checkCourseUsersView($I, $courseId1, [
                $userId1 => $userData1,
                $userId2 => $userData2
            ]);
        $this->checkCourseUsersView($I, $courseId2, [
            ]); // Nobody should be on this course
        $this->checkUserCoursesView($I, $userId1, [
                $courseId1 => $courseData1
            ]);
        $this->checkUserCoursesView($I, $userId2, [
                $courseId1 => $courseData1
            ]);

        // Enroll a user to a different course and ensure only that user
        // is on the course
        $this->enrollSingleUser($I, $courseId2, $userId1);
        $this->checkCourseUsersView($I, $courseId1, [
                $userId1 => $userData1,
                $userId2 => $userData2
            ]);
        $this->checkCourseUsersView($I, $courseId2, [
                $userId1 => $userData1,
            ]);
        $this->checkUserCoursesView($I, $userId1, [
                $courseId1 => $courseData1,
                $courseId2 => $courseData2
            ]);
        $this->checkUserCoursesView($I, $userId2, [
                $courseId1 => $courseData1
            ]);

        // Update a user's data and ensure all views correctly update
        $userData1Updated = [
            'forename' => 'Stupendous',
            'surname' => 'Ralph'
        ];
        $I->updateUser($userId1, $userData1Updated);
        $this->checkCourseUsersView($I, $courseId1, [
                $userId1 => $userData1Updated,
                $userId2 => $userData2,
            ]);
        $this->checkCourseUsersView($I, $courseId2, [
                $userId1 => $userData1Updated,
            ]);
        $this->checkUserCoursesView($I, $userId1, [
                $courseId1 => $courseData1,
                $courseId2 => $courseData2
            ]);
        $this->checkUserCoursesView($I, $userId2, [
                $courseId1 => $courseData1
            ]);
    }

    /**
     * Enroll a single user to a course and confirm the response
     *
     * @param ApiTester $I
     * @param $courseId
     * @param $userId
     */
    protected function enrollSingleUser(ApiTester $I, $courseId, $userId){
        // Enroll a user
        $I->addEnrollment([
                              'courseUniqueId' => $courseId,
                              'userUniqueId' => $userId
                          ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsExactJson((object)[
                "links" => (object)[
                    "self" => "http://api-core/". $this->instanceName ."/enrollment/add"
                ],
                "data" => [
                ],
                "meta" => (object)[
                    "total" => 0
                ]
            ]);
    }

    /**
     * Check the getUsersByCourse response matches
     * an expected dataset
     * @param ApiTester $I
     * @param $courseId
     * @param $userData
     */
    protected function checkCourseUsersView(ApiTester $I, $courseId, $userData){

        $expectedUserData = [];
        foreach($userData as $id => $data){
            $data['uniqueId'] = $id;
            $expectedUserData[] = (object)[
                "type" => "users",
                "id" => $id,
                "attributes" => (object)$data
            ];
        }

        $I->getUsersByCourse($courseId);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsExactJson((object)[
                "links" => (object)[
                    "self" => "http://api-core/". $this->instanceName ."/users/get/by/course/$courseId"
                ],
                "data" => $expectedUserData,
                "meta" => (object)[
                    "total" => count($expectedUserData)
                ]
            ]);
    }

    /**
     * Check the getCoursesByUser response matches
     * an expected dataset
     *
     * @param ApiTester $I
     * @param $userId
     * @param $courseData
     */
    protected function checkUserCoursesView(ApiTester $I, $userId, $courseData){

        $expectedCourseData = [];
        foreach($courseData as $id => $data){
            $data['uniqueId'] = $id;
            $expectedCourseData[] = (object)[
                "type" => "courses",
                "id" => $id,
                "attributes" => (object)$data
            ];
        }

        $I->getCoursesByUsers($userId);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsExactJson((object)[
                "links" => (object)[
                    "self" => "http://api-core/". $this->instanceName ."/courses/get/by/user/$userId"
                ],
                "data" => $expectedCourseData,
                "meta" => (object)[
                    "total" => count($expectedCourseData)
                ]
            ]);
    }

}