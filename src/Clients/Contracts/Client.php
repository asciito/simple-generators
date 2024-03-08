<?php

namespace Asciito\SimpleGenerators\Clients\Contracts;

interface Client
{
    public function __construct(array $options = []);

    public function generateImageFromPrompt(string $prompt, string $size = null): string;

    public function generateTextFromPrompt(string $prompt): string;

    public function getOption(string $key, mixed $value = null): mixed;
}
