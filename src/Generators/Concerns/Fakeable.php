<?php

declare(strict_types=1);

namespace Asciito\SimpleGenerators\Generators\Concerns;

use Asciito\SimpleGenerators\Generators\Contracts\Generator;

trait Fakeable
{
    public static function fake(array $responses = []): Generator
    {
        $instance = new class ([]) implements Generator {
            protected array $responses = [];

            public function __construct(protected array $options)
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
        };

        $instance->addResponses($responses);

        return $instance;
    }
}
