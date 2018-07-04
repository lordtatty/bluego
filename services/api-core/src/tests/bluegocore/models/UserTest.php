<?php
namespace Tests\BlueGoCore\Models;

class UserTest extends \PHPUnit_Framework_TestCase {

    /** @var \BlueGoCore\Models\User */
    protected $sut;

    protected function getTestExistingUserData()
    {
        return [
            'uniqueId' => uniqid(),
            'name' => 'Jim',
        ];
    }

    public function setUp()
    {
        $this->sut = new \BlueGoCore\Models\User();
    }

    public function testNewUserEnsuresUniqueId()
    {
        $uniqueId = $this->sut->getUniqueId();
        $this->assertNotEmpty($uniqueId);
        $this->assertStringMatchesFormat('%s', $uniqueId);
    }

    public function testExistingUserMaintainsExistingUniqueId(){
        $testUserData = $this->getTestExistingUserData();
        $this->sut->setByArray($testUserData);

        $uniqueId = $this->sut->getUniqueId();
        $this->assertSame($testUserData['uniqueId'], $uniqueId);
    }

    public function testGetSetName(){
        $this->sut->setName("Bob");
        $this->assertSame("Bob", $this->sut->getName());
    }

    public function testGetArrayEnsuresUniqueId() {
        $userDataArray = $this->sut->getArray();
        $this->arrayHasKey('uniqueId', $userDataArray);
        $this->assertStringMatchesFormat('%s', $userDataArray['uniqueId']);
    }
}