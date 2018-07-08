<?php
/**
 * Created by PhpStorm.
 * User: tatty
 * Date: 08/07/18
 * Time: 23:05
 */

namespace Tests\Storage;

use BlueGoCore\Exceptions\StorageConfigException;
use BlueGoCore\Models\Course;
use BlueGoCore\Models\User;
use \BlueGoCore\Storage\StorageManager;
use \BlueGoCore\Storage\Types\IPersistableStorageType;
use Tests\TestBase;


class StorageManagerTest extends TestBase{

    /** @var \BlueGoCore\Storage\StorageManager */
    protected $sut;

    function getSutClass()
    {
        return new StorageManager();
    }

    public function test_add_model_returns_self(){
        $result = $this->sut->addModel(new Course());
        $this->assertSame($this->sut, $result);
    }

    /** Test save() method */

    public function test_save_passes_all_models_to_persistent_storage(){
        $model1 = new User();
        $model2 = new Course();

        /** @var IPersistableStorageType|\PHPUnit\Framework\MockObject\MockObject $persistableStorage */
        $persistableStorage = $this->getMockBuilder('\BlueGoCore\Storage\Types\IPersistableStorageType')->getMock();
        $persistableStorage->expects($this->exactly(2))
            ->method('save')
            ->withConsecutive(
                $model1,
                $model2
            );

        $this->sut->addPersistedStorage($persistableStorage);
        $this->sut->addModel($model1);
        $this->sut->addModel($model2);
        $this->sut->save();
    }

    public function test_save_throws_exception_if_no_storage_added(){
        $this->expectExceptionObject(new StorageConfigException());
        $this->expectExceptionMessage('No storage has been added to this storage manager');
        $model1 = new User();
        $model2 = new Course();

        $this->sut->addModel($model1);
        $this->sut->addModel($model2);
        $this->sut->save();
    }

    /** Test getAllData() method */

    /**
     * @dataProvider provider_getAllData_calls_persistent_storage
     */
    public function test_getAllData_calls_persistent_storage($expectedReturn, $return1, $return2){
        $model1 = new User();

        /** @var IPersistableStorageType|\PHPUnit\Framework\MockObject\MockObject $persistableStorage */
        $persistableStorage1 = $this->getMockBuilder('\BlueGoCore\Storage\Types\IPersistableStorageType')->getMock();
        $persistableStorage1->expects($this->exactly(1))
            ->method('getAllData')
            ->withConsecutive(
                $model1
            )
            ->willReturn($return1);

        /** @var IPersistableStorageType|\PHPUnit\Framework\MockObject\MockObject $persistableStorage */
        $persistableStorage2 = $this->getMockBuilder('\BlueGoCore\Storage\Types\IPersistableStorageType')->getMock();
        $persistableStorage2->expects($this->any())
            ->method('getAllData')
            ->withConsecutive(
                $model1
            )
            ->willReturn($return2);

        $this->sut->addPersistedStorage($persistableStorage1);
        $this->sut->addPersistedStorage($persistableStorage2);
        $result = $this->sut->getAllData($model1);
        $this->assertSame($expectedReturn, $result);
    }

    public function provider_getAllData_calls_persistent_storage(){
        return [
            // result if first persistent storage returns nothing
            // but seconds returns
            [
                ['test','test1'],
                [],
                ['test','test1']
            ],
            // result if first persistent storage returns result
            // but second returns nothing
            [
                ['test','test1'],
                ['test','test1'],
                []
            ],
            // empty array if neither persistent storage returns
            [
                [],
                [],
                []
            ],
            // If both could potentially return a result
            // then only the first should be returned
            [
                ['test','test1'],
                ['test','test1'],
                ['test','test2']
            ],
        ];
    }

    public function test_getAllData_throws_exception_if_no_storage_added(){
        $this->expectExceptionObject(new StorageConfigException());
        $this->expectExceptionMessage('No storage has been added to this storage manager');
        $this->sut->getAllData(new Course());
    }


//    public function test_models_can_be_added(){
//
//    }
} 