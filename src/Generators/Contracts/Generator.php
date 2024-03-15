<?php

declare(strict_types=1);

namespace Asciito\SimpleGenerators\Generators\Contracts;

interface Generator
{
    public function __construct(array $options);

    public function prompt(string $text): string;
}
