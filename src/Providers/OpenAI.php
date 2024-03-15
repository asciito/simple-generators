<?php

declare(strict_types=1);

namespace Asciito\SimpleGenerators\Providers;

use Asciito\SimpleGenerators\Providers\Contracts\Client;
use OpenAI\Contracts\ClientContract;
use OpenAI\Contracts\ClientContract as OpenAIClient;

class OpenAI implements Client
{
    protected OpenAIClient $client;

    /**
     * @inheritDoc
     */
    public function __construct(array $options)
    {
        $this->client = \OpenAI::client($options['api']);
    }

    /**
     * @inheritDoc
     */
    public function generateText(string $prompt): string
    {
        $response = $this->client->chat()->create([
            'model' => 'gpt-4-turbo-preview',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => trim($prompt),
                ],
            ]
        ]);

        return $response->choices[0]->message->content;
    }

    /**
     * @inheritDoc
     */
    public function generateImage(string $prompt, string $size = null): string
    {
        $response = $this->client->images()->create([
            'model' => 'dall-e-3',
            'prompt' => $prompt,
            'quality' => 'hd',
            'size' => $size,
        ]);

        return $response->data[0]->url;
    }

    /**
     * Sets the client for the object.
     *
     * @param ClientContract $client
     *
     * @return void
     */
    public function setClient(ClientContract $client): void
    {
        $this->client = $client;
    }
}
