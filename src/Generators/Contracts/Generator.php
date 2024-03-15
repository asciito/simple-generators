<?php

declare(strict_types=1);

namespace Asciito\SimpleGenerators\Generators\Contracts;

interface Generator
{
    /**
     * Generator constructor
     *
     * @param array<string, string> $options
     */
    public function __construct(array $options);

    /**
     * Prompt for the AI Provider
     *
     * @param string $text
     * @return string
     */
    public function prompt(string $text): string;
}
