<?php

namespace GregPriday\ClaudeChat\Tests;

use GregPriday\ClaudeChat\ClaudeModels;
use GregPriday\ClaudeChat\Facades\ClaudeChat;

class RequestTest extends TestCase
{
    public function test_return_json()
    {
        $response = ClaudeChat::createJson([
            'system' => 'Always respond with a json object',
            'model' => ClaudeModels::MODEL_HAIKU,
            'messages' => [['role' => 'user', 'content' => 'Hello, Claude!']],
        ]);

        $this->assertIsObject($response->content[0]->object);
    }
}
