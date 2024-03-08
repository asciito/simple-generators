<?php

namespace Asciito\SimpleGenerators\Clients\Exceptions;

use Asciito\SimpleGenerators\Clients\Contracts\Exceptions\ClientException;

class InvalidImageSize extends \Exception implements ClientException
{
    public function __construct(protected string $clientID, string $message)
    {
        parent::__construct("[{$this->clientID}]: ".$message);
    }

    public static function make(string $client, string $message = ''): static
    {
        return new static($client, $message);
    }
}
