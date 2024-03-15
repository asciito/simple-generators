<?php

declare(strict_types=1);

namespace Asciito\SimpleGenerators;

use Asciito\SimpleGenerators\Generators\Contracts\Generator;
use Asciito\SimpleGenerators\Generators\ImageGenerator;
use Asciito\SimpleGenerators\Generators\TextGenerator;

class Factory
{
    protected static Generator|null $fakeGenerator = null;

    public static function make(string $type, array $options): Generator
    {
        if (static::$fakeGenerator) {
            return static::$fakeGenerator;
        }

        if ($type === 'text') {
            return new TextGenerator($options);
        }

        return new ImageGenerator($options);
    }

    public static function fake(Generator $fake): void
    {
        static::$fakeGenerator = $fake;
    }

    public static function flushFakeGenerator(): void
    {
        static::$fakeGenerator = null;
    }
}
