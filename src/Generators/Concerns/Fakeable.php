<?php

declare(strict_types=1);

namespace Asciito\SimpleGenerators\Generators\Concerns;

use Asciito\SimpleGenerators\Generators\Contracts\Generator;
use Asciito\SimpleGenerators\Providers\Contracts\Client;

trait Fakeable
{
    public static function fake(array $responses = []): Generator
    {
        $instance = new class () implements Generator {
            protected array $responses = [];

            public function __construct(Client|null $client = null)
            {
                //
            }

            public function prompt(string $text): string
            {
                return $this->getResponse();
            }

            public function addResponses(array $responses): void
            {
                $this->responses = [...array_reverse($responses), ...$this->responses];
            }

            protected function getResponse(): string
            {
                return array_pop($this->responses);
            }

            public function setClient(Client $client): void
            {
                //
            }
        };

        $instance->addResponses($responses);

        return $instance;
    }
}
