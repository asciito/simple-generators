<?php

declare(strict_types=1);

namespace Asciito\SimpleGenerators\Generators\Contracts;

interface Fake
{
    public static function fake(array $responses = []): Generator;
}
