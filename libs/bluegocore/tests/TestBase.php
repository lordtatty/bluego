<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

abstract class TestBase extends TestCase {

    /** @var \BlueGoCore\Models\ModelAbstract */
    protected $sut;

    private $mocks = [];

    abstract function getSutClass();

    public function setUp()
    {
        $this->sut = $this->getSutClass();
    }

    public function tearDown(){
        $this->mocks = [];
    }

    /**
     * return \BlueGoCore\Storage\StorageManager|PHPUnit\Framework\MockObject\MockObject
     */
    protected function getStorageManagerMock(){
        return $this->getGenericMock('\BlueGoCore\Storage\StorageManager');
    }

    /**
     * return \BlueGoCore\Models\Views\UserCourseView|PHPUnit\Framework\MockObject\MockObject
     */
    protected function getUserCourseViewMock(){
        return $this->getGenericMock('\BlueGoCore\Models\Views\UserCourseView');
    }

    /**
     * return \BlueGoCore\Models\Views\CourseUserView|PHPUnit\Framework\MockObject\MockObject
     */
    protected function getCourseUserViewMock(){
        return $this->getGenericMock('\BlueGoCore\Models\Views\CourseUserView');
    }

    protected function getGenericMock($class){
        if(!isset($this->mocks[$class])) {
            $this->mocks[$class] =
                $this->getMockBuilder($class)
                ->disableOriginalConstructor()
                ->getMock();
        }
        return $this->mocks[$class];
    }

    protected function expectStorageManagerAddModels(...$models){
        $this->expectSetOnMock(
            $this->getStorageManagerMock(),
            'addModel',
            ...$models
        );
    }

    protected function expectSetOnMock(\PHPUnit\Framework\MockObject\MockObject $mockObject, $method, ...$value){
        foreach($value as $k => $v){
            $value[$k] = [$this->identicalTo($v)];
        }
        $mockObject->expects($this->exactly(count($value)))
            ->method($method)
            ->withConsecutive(...$value);
    }

} 