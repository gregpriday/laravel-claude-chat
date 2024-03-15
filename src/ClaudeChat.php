<?php

namespace GregPriday\ClaudeChat;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleRetry\GuzzleRetryMiddleware;
use stdClass;

class ClaudeChat
{
    private Client $client;

    private string $apiKey;

    private string $apiUrl;

    public function __construct(string $apiKey, string $apiUrl)
    {
        $this->apiKey = $apiKey;
        $this->apiUrl = $apiUrl;

        $stack = HandlerStack::create();
        $stack->push(GuzzleRetryMiddleware::factory(config('claude.retry', [
            'retries' => 5,
            'retry_on_status' => [429, 500, 502, 503, 504],
            'retry_on_timeout' => true,
            'delay' => 1000,
            'multiplier' => 2,
            'max_delay' => 10000,
        ])));

        $this->client = new Client([
            'base_uri' => $this->apiUrl,
            'timeout' => config('claude.request_timeout', 30),
            'handler' => $stack,
            'headers' => [
                'x-api-key' => $this->apiKey,
                'anthropic-version' => '2023-06-01',
                'content-type' => 'application/json',
            ],
        ]);
    }

    /**
     * Send a request to the Claude API with custom arguments.
     *
     * @param  array  $arguments  The request payload for the Claude API.
     * @return stdClass The response from the Claude API.
     *
     * @throws GuzzleException
     */
    public function create(array $arguments): stdClass
    {
        $arguments = array_merge([
            'max_tokens' => 4096,
        ], $arguments);

        $response = $this->client->post('', [
            'json' => $arguments,
        ]);

        $responseData = json_decode($response->getBody()->getContents());

        return $responseData;
    }

    public function createJson(array $arguments): stdClass
    {
        // Make sure that the assistant responds with pure JSON
        $arguments['messages'][] = ['role' => 'assistant', 'content' => '```json'];
        $response = $this->create($arguments);

        // Check if the response has the 'content' field, and it's an array with at least one item
        if (! empty($response->content)) {

            foreach ($response->content as &$content) {
                // Re-add the ```json backticks to the response
                $content->text = '```json'.$content->text;

                // Extract the text between backticks, treating it as JSON
                if (preg_match('/```json(.*?)```/s', $content->text, $matches)) {
                    // $matches[1] contains the text between the first pair of backticks found
                    $jsonText = trim($matches[1]);

                    // Attempt to parse the extracted text as JSON
                    $jsonObject = json_decode($jsonText);

                    // Check if json_decode succeeded
                    if (json_last_error() === JSON_ERROR_NONE && $jsonText !== '') {
                        // If the extracted text is valid JSON, update the content object
                        $content->type = 'object';
                        $content->object = $jsonObject;
                    }
                }
            }
        }

        // If the 'content' or 'text' key is not set, return the whole response as an array
        return $response;
    }
}
