<?php

namespace Tests\Responses;

use PHPUnit_Framework_TestCase;
use Vulcan\Rivescript\Rivescript;

abstract class ResponseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Rivescript
     */
    protected $rivescript;

    public function setUp()
    {
        $this->rivescript = new Rivescript();

        $this->rivescript->load(realpath('./resources/brains/test.rive'));
    }
}
