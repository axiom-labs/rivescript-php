<?php

namespace Tests\Responses;

class AtomicResponseTest extends ResponseTest
{
    public function testAtomicReply()
    {
        $response = $this->rivescript->reply(null, 'hello bot');

        $this->assertEquals('Hello human.', $response);
    }

    public function testAtomicReplyWithVariable()
    {
        $response = $this->rivescript->reply(null, 'what is your name?');

        $this->assertEquals('You can call me Rivescript Test Bot.', $response);
    }
}
