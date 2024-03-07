<?php

namespace Asciito\SimpleGenerators\Clients\Contracts\Exceptions;

interface ClientException extends \Throwable
{
    public static function make(string $client, string $message = ''): static;
}
