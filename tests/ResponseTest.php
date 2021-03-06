<?php

namespace Tests;

use PHPUnit_Framework_TestCase;
use Axiom\Rivescript\Rivescript;

abstract class ResponseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Rivescript
     */
    protected $rivescript;

    public function setUp()
    {
        $this->rivescript = new Rivescript();

        $this->rivescript->load(realpath('./tests/resources/test.rive'));
    }
}
