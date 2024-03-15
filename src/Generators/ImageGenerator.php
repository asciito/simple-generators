<?php

declare(strict_types=1);

namespace Asciito\SimpleGenerators\Generators;

use Asciito\SimpleGenerators\Generators\Concerns\Fakeable;
use Asciito\SimpleGenerators\Generators\Contracts\Fake;
use Asciito\SimpleGenerators\Generators\Contracts\Generator;
use Asciito\SimpleGenerators\Providers\Contracts\Client;

class ImageGenerator implements Generator, Fake
{
    use Fakeable;

    /**
     * @inheritDoc
     */
    public function __construct(protected Client|null $client = null)
    {
        //
    }

    /**
     * @inheritDoc
     */
    public function prompt(string $text): string
    {
        return $this->client->generateImage($text);
    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
    }
}
