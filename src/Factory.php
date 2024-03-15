<?php

declare(strict_types=1);

namespace Asciito\SimpleGenerators;

use Asciito\SimpleGenerators\Generators\Contracts\Generator;
use Asciito\SimpleGenerators\Generators\ImageGenerator;
use Asciito\SimpleGenerators\Generators\TextGenerator;
use Asciito\SimpleGenerators\Providers\Contracts\Client;
use Asciito\SimpleGenerators\Providers\OpenAI;
use Exception;

class Factory
{
    /**
     * @var Generator|null Fake generator
     */
    protected static Generator|null $fakeGenerator = null;

    /**
     * @var array<string, class-string>
     */
    protected static array $clients = [
        'open-ai' => OpenAI::class,
    ];

    /**
     * Create the given type of generator
     *
     * @param string $type The type of the generator
     * @param string|null $client
     * @param array<string, string> $options
     * @return Generator
     *
     * @throws Exception if the provided client does not exist
     */
    protected static function make(string $type, string $client = null, array $options = []): Generator
    {
        if (static::$fakeGenerator) {
            return static::$fakeGenerator;
        }

        $generator = ($type === 'text') ? new TextGenerator() : new ImageGenerator();

        $generator->setClient(static::buildClient($client, $options));

        return $generator;
    }

    /**
     * Build the given client
     *
     * @param string|null $client
     * @param array<string, string> $options
     * @return Client
     *
     * @throws Exception if the provided client does not exist
     */
    protected static function buildClient(string $client = null, array $options = []): Client
    {
        if (is_null($client)) {
            return new static::$clients['open-ai']($options);
        }

        if (! array_key_exists($client, static::$clients)) {
            throw new Exception("The given client [$client] does not exists");
        }

        return new static::$clients[$client]($options);
    }

    /**
     * Create a text generator
     *
     * @param string|null $client
     * @param array<string, string> $options
     *
     * @return Generator
     * @throws Exception if the provided client does not exist
     */
    public static function text(string $client = null, array $options = []): Generator
    {
        return static::make('text', $client, $options);
    }

    /**
     * Create an image generator
     *
     * @param string|null $client
     * @param array<string, string> $options
     *
     * @return Generator
     * @throws Exception if the provided client does not exist
     */
    public static function image(string $client = null, array $options = []): Generator
    {
        return static::make('image', $client, $options);
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
