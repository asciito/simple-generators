<?php

declare(strict_types=1);

namespace Asciito\SimpleGenerators\Generators;

use Asciito\SimpleGenerators\Generators\Concerns\Fakeable;
use Asciito\SimpleGenerators\Generators\Contracts\Fake;
use Asciito\SimpleGenerators\Generators\Contracts\Generator;
use OpenAI;
use OpenAI\Contracts\ClientContract;

class TextGenerator implements Generator, Fake
{
    use Fakeable;

    protected ClientContract $client;

    /**
     * @inheritDoc
     */
    public function __construct(protected array $options)
    {
        $this->client = OpenAI::client($this->options['api']);
    }

    public function prompt(string $text): string
    {
        $response = $this->client->chat()->create([
            "model" => "gpt-4-turbo-preview",
            "messages" => [
                [
                    "role" => "user",
                    "content" => $text,
                ],
            ]
        ]);

        return $response->choices[0]->message->content;
    }
}
