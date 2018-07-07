<?php
namespace Tests;

use BlueGoCore\Models\Course;

class CourseTest extends TestBase {

    /** @var \BlueGoCore\Models\Course */
    protected $sut;

    protected function _getTestData()
    {
        return [
            'uniqueId' => uniqid(),
            'title' => 'Course 1',
            'course_code' => 'course_1'
        ];
    }

    function _getModel()
    {
        return new Course();
    }

    /** Title property */
    public function test_title_set_get(){
        $this->assertNull($this->sut->getTitle());
        $this->sut->setTitle("Course 1");
        $this->assertSame("Course 1", $this->sut->getTitle());
    }

    public function test_title_set_from_array(){
        $this->assertNull($this->sut->getTitle());
        $this->sut->setByArray($this->_getTestData());
        $this->assertSame("Course 1", $this->sut->getTitle());
    }

    /** Course code property */
    public function test_course_code_set_get(){
        $this->assertNull($this->sut->getCourseCode());
        $this->sut->setCourseCode("course_1");
        $this->assertSame("course_1", $this->sut->getCourseCode());
    }

    public function test_course_code_set_from_array(){
        $this->assertNull($this->sut->getCourseCode());
        $this->sut->setByArray($this->_getTestData());
        $this->assertSame("course_1", $this->sut->getCourseCode());
    }

}