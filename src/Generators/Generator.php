<?php

namespace Asciito\SimpleGenerators\Generators;

use Asciito\SimpleGenerators\Clients\ClientFake;
use Asciito\SimpleGenerators\Clients\Contracts\Client;
use Asciito\SimpleGenerators\Clients\Exceptions\ClientNotFoundException;

abstract class Generator
{
    protected static array $clients = [
        'open-ai' => \Asciito\SimpleGenerators\Clients\OpenAI\Client::class,
    ];

    public function __construct(protected Client $client)
    {
        //
    }

    abstract public function prompt(string $text): string;

    public static function make(string $clientName, ?Client $client = null): static
    {
        if (is_null($client)) {
            $client = static::resolveClient($clientName);
        }

        return new static($client);
    }

    public static function resolveClient(string $client): Client
    {
        if (is_null(static::$clients[$client] ?? null)) {
            throw ClientNotFoundException::make($client);
        }

        $instance = static::$clients[$client];

        return new $instance();
    }

    /**
     * Fake the text generation
     */
    public static function fakeClient(array $responses = []): Client
    {
        return new ClientFake($responses['image'] ?? [], $responses['text'] ?? []);
    }
}
