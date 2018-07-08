<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

abstract class TestBase extends TestCase {

    /** @var \BlueGoCore\Models\ModelAbstract */
    protected $sut;

    abstract function getSutClass();

    public function setUp()
    {
        $this->sut = $this->getSutClass();
    }

} 