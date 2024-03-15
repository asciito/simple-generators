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
     * @var array<string, string>
     */
    protected array $availableSizes = [
        '1024-w' => '1024x1024',
        '1024-h' => '1024x1792',
        '1791-w' => '1792x1024',
    ];

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
            'size' => $this->getSize($size),
        ]);

        return $response->data[0]->url;
    }

    /**
     * @param string|null $size
     * @return string
     */
    protected function getSize(string $size = null): string
    {
        return $this->availableSizes[$size] ?? $this->availableSizes['1024-w'];
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
