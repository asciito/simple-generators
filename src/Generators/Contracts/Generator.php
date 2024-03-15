<?php

declare(strict_types=1);

namespace Asciito\SimpleGenerators\Generators\Contracts;

use Asciito\SimpleGenerators\Providers\Contracts\Client;

interface Generator
{
    /**
     * Generator constructor
     *
     * @param Client|null $client AI Client
     */
    public function __construct(Client $client = null);

    /**
     * Prompt for the AI Provider
     *
     * @param string $text
     * @return string
     */
    public function prompt(string $text): string;

    public function setClient(Client $client): void;
}
