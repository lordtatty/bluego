<?php
/**
 * Created by PhpStorm.
 * User: tatty
 * Date: 08/07/18
 * Time: 23:00
 */

namespace Tests\Models;


use Tests\TestBase;

abstract class ModelBase extends TestBase {

    abstract protected function _getTestData();

    public function testNewModelEnsuresUniqueId()
    {
        $uniqueId = $this->sut->getUniqueId();
        $this->assertNotEmpty($uniqueId);
        $this->assertStringMatchesFormat('%s', $uniqueId);
    }

    public function testExistingModelMaintainsExistingUniqueId(){
        $testUserData = $this->_getTestData();
        $this->sut->loadFromArray($testUserData);

        $uniqueId = $this->sut->getUniqueId();
        $this->assertSame($testUserData['uniqueId'], $uniqueId);
    }

    public function testGetArrayEnsuresUniqueId() {
        $userDataArray = $this->sut->getArray();
        $this->assertArrayHasKey('uniqueId', $userDataArray);
        $this->assertNotEmpty($userDataArray['uniqueId']);
        $this->assertStringMatchesFormat('%s', $userDataArray['uniqueId']);
    }
} 