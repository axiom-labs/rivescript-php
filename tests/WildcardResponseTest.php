<?php

namespace Tests;

class WildcardResponseTest extends ResponseTest
{
    public function testWildcardReplyOneStar()
    {
        $response = $this->rivescript->reply('my favorite thing in the world is programming');

        $this->assertEquals('Why do you like programming so much?', $response);
    }

    public function testWildcardReplyTwoStar()
    {
        $response = $this->rivescript->reply('John told me to say hello');

        $this->assertEquals('Why would john have told you to say hello?', $response);
    }

    public function testWildcardReplyOneStarMultipleWords()
    {
        $response = $this->rivescript->reply('I think the sky is orange.');

        $this->assertEquals('Do you think the sky is orange a lot?', $response);
    }

    public function testWildcardReply()
    {
        $response = $this->rivescript->reply('I am twenty years old');

        $this->assertEquals('Tell me that as a number instead of spelled out like "twenty"', $response);
    }

    public function testWildcardReplyNumber()
    {
        $response = $this->rivescript->reply('I am 20 years old');

        $this->assertEquals('I will remember that you are 20 years old.', $response);
    }

    public function testCatchAllReply()
    {
        $response = $this->rivescript->reply('aesfaeisfhliuashefaef');

        $this->assertEquals('I\'m sorry but I don\'t understand.', $response);
    }

    public function testCatchAllReplyMultipleWords()
    {
        $response = $this->rivescript->reply('lorem ipsum dolar amit');

        $this->assertEquals('I\'m sorry but I don\'t understand.', $response);
    }
}
