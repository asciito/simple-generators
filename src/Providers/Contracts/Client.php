<?php

declare(strict_types=1);

namespace Asciito\SimpleGenerators\Providers\Contracts;

interface Client
{
    /**
     * AI provider's constructor
     *
     * @param array<string, string> $options
     */
    public function __construct(array $options);

    /**
     * Generate text from the provided prompt
     *
     * @param string $prompt
     * @return string The text response
     */
    public function generateText(string $prompt): string;

    /**
     * Generate an image from the provided prompt
     *
     * @param string $prompt
     * @param string|null $size
     * @return string The URL of the image
     */
    public function generateImage(string $prompt, string $size = null): string;
}
