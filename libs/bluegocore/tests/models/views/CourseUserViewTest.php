<?php
namespace Tests\Models;

use BlueGoCore\Models\Course;
use BlueGoCore\Models\User;
use BlueGoCore\Models\Views\CourseUserView;

class CourseUserViewTest extends ModelBase {

    /** @var \BlueGoCore\Models\Views\CourseUserView */
    protected $sut;

    protected function _getTestData()
    {
        return [
            'uniqueId' => uniqid(),
            'course' => 'Course 1',
            'users' => ['user_1']
        ];
    }

    function getSutClass()
    {
        return new CourseUserView();
    }

    /** Set the Course */
    public function test_course_set_get(){
        $course = new Course();
        $this->assertNull($this->sut->getCourse());
        $this->sut->setCourse($course);
        $this->assertSame($course, $this->sut->getCourse());
    }

    /** Set the Course */
    public function test_user_set_get(){
        $this->assertNull($this->sut->getUsers());

        $user1 = new User();
        $this->sut->addUser($user1);
        $this->assertInternalType('array', $this->sut->getUsers());
        $this->assertCount(1, $this->sut->getUsers());
        $this->assertSame([$user1->getUniqueId() => $user1], $this->sut->getUsers());

        $user2 = new User();
        $this->sut->addUser($user2);
        $this->assertInternalType('array', $this->sut->getUsers());
        $this->assertCount(2, $this->sut->getUsers());
        $this->assertSame([$user1->getUniqueId() => $user1, $user2->getUniqueId() => $user2], $this->sut->getUsers());

    }


}