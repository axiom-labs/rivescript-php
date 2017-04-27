<?php

namespace Tests\Interpreter;

use PHPUnit_Framework_TestCase;
use Vulcan\Rivescript\Support\Str;

class StrTest extends PHPUnit_Framework_TestCase
{
    public function testRemoveWhitespace()
    {
        $utility = new Str();
        $line = ' + hello   ';

        $this->assertEquals('+ hello', $utility->removeWhitespace($line));
    }

    public function testStartsWith()
    {
        $utility = new Str();
        $haystack = '/* This is a comment */';
        $needle = '/*';

        $this->assertEquals(true, $utility->startsWith($haystack, $needle));
    }

    public function testEndsWith()
    {
        $utility = new Str();
        $haystack = '/* This is a comment */';
        $needle = '*/';

        $this->assertEquals(true, $utility->endsWith($haystack, $needle));
    }
}
