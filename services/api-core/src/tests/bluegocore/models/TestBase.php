<?php


namespace Tests\BlueGoCore\Models;


abstract class TestBase extends \PHPUnit_Framework_TestCase {

    /** @var \BlueGoCore\Models\ModelAbstract */
    protected $sut;

    abstract protected function _getTestData();

    abstract function _getModel();

    public function setUp()
    {
        $this->sut = $this->_getModel();
    }

    public function testNewModelEnsuresUniqueId()
    {
        $uniqueId = $this->sut->getUniqueId();
        $this->assertNotEmpty($uniqueId);
        $this->assertStringMatchesFormat('%s', $uniqueId);
    }

    public function testExistingModelMaintainsExistingUniqueId(){
        $testUserData = $this->_getTestData();
        $this->sut->setByArray($testUserData);

        $uniqueId = $this->sut->getUniqueId();
        $this->assertSame($testUserData['uniqueId'], $uniqueId);
    }

    public function testGetArrayEnsuresUniqueId() {
        $userDataArray = $this->sut->getArray();
        $this->assertArrayHasKey('uniqueId', $userDataArray);
        $this->assertNotEmpty($userDataArray['uniqueId'], $userDataArray['']);
        $this->arrayHasKey('uniqueId', $userDataArray);
        $this->assertStringMatchesFormat('%s', $userDataArray['uniqueId']);
    }

} 