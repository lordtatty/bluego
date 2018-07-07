<?php
namespace Tests\BlueGoCore\Models;

use BlueGoCore\Models\User;

class UserTest extends TestBase {

    /** @var \BlueGoCore\Models\User */
    protected $sut;

    function _getModel()
    {
        return new User();
    }

    protected function _getTestData()
    {
        return [
            'uniqueId' => uniqid(),
            'forename' => 'Jim',
            'surname' => 'Henson',
        ];
    }

    public function testGetSetForeame(){
        $this->sut->setForename("Bob");
        $this->assertSame("Bob", $this->sut->getForename());
    }

    public function testGetSetSurname(){
        $this->sut->setSurname("Bob");
        $this->assertSame("Bob", $this->sut->getSurname());
    }
}