<?php

namespace Asciito\SimpleGenerators\Generators;

class TextGenerator extends Generator
{
    public function prompt(string $text): string
    {
        return $this->client->generateTextFromPrompt($text);
    }
}
