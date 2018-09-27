<?php
namespace Tests\Models;

use BlueGoCore\Models\Course;
use BlueGoCore\Models\User;
use BlueGoCore\Models\Views\UserCourseView;

class UserCourseViewTest extends ModelBase {

    /** @var \BlueGoCore\Models\Views\UserCourseView */
    protected $sut;

    protected function _getTestData()
    {
        return [
            'uniqueId' => uniqid(),
            'user' => 'User 1',
            'courses' => ['course_1']
        ];
    }

    function getSutClass()
    {
        return new UserCourseView();
    }

    /** Set the Course */
    public function test_user_set_get(){
        $user = new User();
        $this->assertNull($this->sut->getUser());
        $this->sut->setUser($user);
        $this->assertSame($user, $this->sut->getUser());
    }

    /** Set the Course */
    public function test_courses_set_get(){
        $this->assertNull($this->sut->getCourses());

        $course1 = new Course();
        $this->sut->addCourse($course1);
        $this->assertInternalType('array', $this->sut->getCourses());
        $this->assertCount(1, $this->sut->getCourses());
        $this->assertSame([$course1->getUniqueId() => $course1], $this->sut->getCourses());

        $course2 = new Course();
        $this->sut->addCourse($course2);
        $this->assertInternalType('array', $this->sut->getCourses());
        $this->assertCount(2, $this->sut->getCourses());
        $this->assertSame([$course1->getUniqueId() => $course1, $course2->getUniqueId() => $course2], $this->sut->getCourses());

    }


}