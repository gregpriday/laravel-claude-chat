<?php

// config for GregPriday/ClaudeChat
return [
    'api_key' => env('CLAUDE_API_KEY'),
    'endpoint' => env('CLAUDE_ENDPOINT', 'https://api.anthropic.com/v1/messages'),
    'request_timeout' => env('CLAUDE_REQUEST_TIMEOUT', 30),
    'retry' => [
        'retries' => 5,
        'retry_on_status' => [429, 500, 502, 503, 504],
        'retry_on_timeout' => true,
        'delay' => 1000,
        'multiplier' => 2,
        'max_delay' => 10000,
    ],
];
