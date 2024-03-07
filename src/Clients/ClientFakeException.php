<?php

namespace Asciito\SimpleGenerators\Clients;

use Asciito\SimpleGenerators\Clients\Contracts\Exceptions\ClientException;

class ClientFakeException extends \Exception implements ClientException
{
    public static function make(string $client, $message = ''): static
    {
        return new static($message);
    }
}
