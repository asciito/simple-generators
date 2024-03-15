<?php

declare(strict_types=1);

namespace Asciito\SimpleGenerators\Generators;

use Asciito\SimpleGenerators\Generators\Concerns\Fakeable;
use Asciito\SimpleGenerators\Generators\Contracts\Fake;
use Asciito\SimpleGenerators\Generators\Contracts\Generator;

class ImageGenerator implements Generator, Fake
{
    use Fakeable;

    public function __construct(protected array $options)
    {
        //
    }

    public function prompt(string $text): string
    {
        // TODO: Implement prompt() method.
    }
}
