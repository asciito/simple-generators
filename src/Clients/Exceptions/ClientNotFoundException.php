<?php

namespace Asciito\SimpleGenerators\Clients\Exceptions;

use Asciito\SimpleGenerators\Clients\Contracts\Exceptions\ClientException;

class ClientNotFoundException extends \Exception implements ClientException
{
    #[\Override]
    public static function make(string $client, string $message = ''): static
    {
        return new static("The client [$client] does not exists");
    }
}
