<?php

namespace Tests;

class TriggerTagsTest extends ResponseTest
{
    public function testBotTag()
    {
        $response = $this->rivescript->reply('Beta');

        $this->assertEquals('What can I do for you?', $response);
    }
}
