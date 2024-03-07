<?php

namespace Asciito\SimpleGenerators\Generators;

class ImageGenerator extends Generator
{
    public function prompt(string $text): string
    {
        return $this->client->generateImageFromPrompt($text);
    }
}
