<?php

declare(strict_types=1);

namespace Asciito\SimpleGenerators\Generators;

use Asciito\SimpleGenerators\Generators\Concerns\Fakeable;
use Asciito\SimpleGenerators\Generators\Contracts\Fake;
use Asciito\SimpleGenerators\Generators\Contracts\Generator;
use Asciito\SimpleGenerators\Providers\Contracts\Client;

class TextGenerator implements Generator, Fake
{
    use Fakeable;

    /**
     * @inheritDoc
     */
    public function __construct(protected Client|null $client = null)
    {
    }

    public function prompt(string $text): string
    {
        return $this->client->generateText($text);
    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
    }
}
