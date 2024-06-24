# Laravel Claude Chat

Laravel Claude Chat is a package that provides a simple way to integrate Anthropic's Claude AI into your Laravel application. It allows you to easily send requests to the Claude API and receive responses.

## Features

- Easy integration with Laravel
- Supports custom arguments for Claude API requests
- Automatic retry mechanism for failed requests
- Facade for convenient access to the `ClaudeChat` class

## Installation

You can install the package via composer:

```bash
composer require gregpriday/laravel-claude-chat
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --provider="GregPriday\ClaudeChat\ClaudeChatServiceProvider"
```

The published configuration file is located at `config/claude.php`. You need to set your Claude API key and endpoint in this file:

```php
return [
    'api_key' => env('CLAUDE_API_KEY'),
    'endpoint' => env('CLAUDE_API_URL'),
    'request_timeout' => 30,
    'retry' => [
        'retries' => 5,
        'retry_on_status' => [429, 500, 502, 503, 504],
        'retry_on_timeout' => true,
        'delay' => 1000,
        'multiplier' => 2,
        'max_delay' => 10000,
    ],
];
```

Make sure to add your Claude API key and endpoint to your `.env` file:

```
CLAUDE_API_KEY=your-claude-api-key
CLAUDE_API_URL=https://api.anthropic.com/v1/complete
```

## Usage

You can use the `ClaudeChat` class to send requests to the Claude API:

```php
use GregPriday\ClaudeChat\ClaudeChat;

$claudeChat = new ClaudeChat(config('claude.api_key'), config('claude.endpoint'));

$response = $claudeChat->create([
    'prompt' => 'Hello, Claude!',
    'model' => 'claude-v1',
]);

echo $response->completion;
```

You can also use the `ClaudeChat` facade for a more convenient way to access the class:

```php
use GregPriday\ClaudeChat\Facades\ClaudeChat;

$response = ClaudeChat::create([
    'prompt' => 'Hello, Claude!',
    'model' => 'claude-v1',
]);

echo $response->completion;
```

### Retrieving JSON Responses

If you want to retrieve the response from Claude as a JSON object, you can use the `createJson` method:

```php
$response = ClaudeChat::createJson([
    'prompt' => 'Generate a JSON object with a "message" field.',
]);

$jsonObject = $response->content[0]->object;
```

The `createJson` method automatically extracts the JSON object from the response and returns it as a PHP object.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Greg Priday](https://github.com/gregpriday)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
