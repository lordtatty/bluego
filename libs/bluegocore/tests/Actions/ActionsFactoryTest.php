<?php

namespace models\Actions;


use BlueGoCore\Actions\ActionsFactory;
use BlueGoCore\Storage\StorageManager;
use Tests\TestBase;

class ActionsFactoryTest extends TestBase {

    /** @var \BlueGoCore\Actions\ActionsFactory */
    protected $sut;

    function getSutClass()
    {
        return new ActionsFactory($this->getStorageManagerMock());
    }

    public function test_get_enroll_user_to_course_object(){
        $object = $this->sut->getEnrollUserToCourseAction();
        $this->assertInstanceOf('\BlueGoCore\Actions\EnrollUserToCourse', $object);
        $this->assertStorageManagerIs($object, $this->getStorageManagerMock());
    }

    /**
     * Helper asserton to assert that the storage manager in an object
     * matches a passed storage manager
     *
     * Uses reflection
     *
     * @param $object
     * @param StorageManager $expectedStorageManager
     */
    protected function assertStorageManagerIs($object, StorageManager $expectedStorageManager){
        $class = new \ReflectionClass($object);
        $property = $class->getProperty("storageManager");
        $property->setAccessible(true);
        $foundStorageManager = $property->getValue($object);
        $this->assertInstanceOf('BlueGoCore\Storage\StorageManager', $foundStorageManager);
        $this->assertSame($expectedStorageManager, $foundStorageManager);
    }

}