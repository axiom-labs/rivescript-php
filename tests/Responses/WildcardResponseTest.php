<?php

namespace Tests\Responses;

class WildcardResponseTest extends ResponseTest
{
    public function testWildcardReplyOneStar()
    {
        $response = $this->rivescript->reply(null, 'my favorite thing in the world is programming');

        $this->assertEquals('Why do you like programming so much?', $response);
    }

    public function testWildcardReplyTwoStar()
    {
        $response = $this->rivescript->reply(null, 'John told me to say hello');

        $this->assertEquals('Why would john have told you to say hello?', $response);
    }

    public function testWildcardReplyOneStarMultipleWords()
    {
        $response = $this->rivescript->reply(null, 'I think the sky is orange.');

        $this->assertEquals('Do you think the sky is orange a lot?', $response);
    }

    public function testWildcardReply()
    {
        $response = $this->rivescript->reply(null, 'I am twenty years old');

        $this->assertEquals('Tell me that as a number instead of spelled out like "twenty"', $response);
    }

    public function testWildcardReplyNumber()
    {
        $response = $this->rivescript->reply(null, 'I am 20 years old');

        $this->assertEquals('I will remember that you are 20 years old.', $response);
    }
}
