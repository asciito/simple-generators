<?php

declare(strict_types=1);

namespace Asciito\SimpleGenerators;

use Asciito\SimpleGenerators\Generators\Contracts\Generator;
use Asciito\SimpleGenerators\Generators\ImageGenerator;
use Asciito\SimpleGenerators\Generators\TextGenerator;

class Factory
{
    /**
     * @var Generator|null Fake generator
     */
    protected static Generator|null $fakeGenerator = null;

    /**
     * Create the given type of generator
     *
     * @param string $type The type of the generator
     * @param array<string, string> $options The options available for the generator
     * @return Generator
     */
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

    /**
     * Set a fake generator
     *
     * @param Generator $fake
     * @return void
     */
    public static function fake(Generator $fake): void
    {
        static::$fakeGenerator = $fake;
    }

    /**
     * Remove the fake generator
     *
     * @return void
     */
    public static function flushFakeGenerator(): void
    {
        static::$fakeGenerator = null;
    }
}
