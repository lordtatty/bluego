<?php
/**
 * Created by PhpStorm.
 * User: tatty
 * Date: 27/09/18
 * Time: 17:32
 */

namespace models\Actions;


use BlueGoCore\Actions\EnrollUserToCourse;
use BlueGoCore\Models\Course;
use BlueGoCore\Models\User;
use Tests\TestBase;

class EnrollUserToCourseTest extends TestBase {

    /** @var \BlueGoCore\Actions\EnrollUserToCourse */
    protected $sut;

    function getSutClass()
    {
        return new EnrollUserToCourse(
            $this->getStorageManagerMock(),
            $this->getUserCourseViewMock(),
            $this->getCourseUserViewMock()
        );
    }

    public function test_add_user_to_course_happy_path(){
        $user = new User();
        $course = new Course();

        // Assert CourseUserView is updated correctly
        $this->expectSetOnMock($this->getCourseUserViewMock(), 'addUser', $user);
        $this->expectSetOnMock($this->getCourseUserViewMock(), 'setCourse', $course);

        // Assert CourseUserView is updated correctly
        $this->expectSetOnMock($this->getUserCourseViewMock(), 'setUser', $user);
        $this->expectSetOnMock($this->getUserCourseViewMock(), 'addCourse', $course);

        // Assert views are added to the storage manager
        $this->expectStorageManagerAddViews(
            $this->getUserCourseViewMock(),
            $this->getCourseUserViewMock()
        );

        // Perform the test
        $this->sut->setUser($user);
        $this->sut->setCourse($course);
        $this->sut->perform();
    }

}