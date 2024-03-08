<?php

namespace Asciito\SimpleGenerators\Clients;

use Asciito\SimpleGenerators\Clients\Contracts\Client as ClientContract;
use Asciito\SimpleGenerators\Clients\Contracts\Exceptions\ClientException;

class ClientFake implements ClientContract
{
    protected string $textDefaultResponse = 'This is a fake response';

    protected string $imageDefaultResponse = 'https://picsum.photos/1366/768?grayscale';

    public function __construct(protected array $imageResponses = [], protected array $textResponses = [], protected array $options = [])
    {
        //
    }

    #[\Override]
    public function generateImageFromPrompt(string $prompt, string $size = null): string
    {
        if (empty($this->imageResponses)) {
            return $this->imageDefaultResponse;
        }

        $response = array_pop($this->imageResponses);

        $this->mayThrow($response);

        return $response;
    }

    #[\Override]
    public function generateTextFromPrompt(string $prompt): string
    {
        if (empty($this->textResponses)) {
            return $this->textDefaultResponse;
        }

        $response = array_pop($this->textResponses);

        $this->mayThrow($response);

        return $response;
    }

    #[\Override]
    public function getOption(string $key, mixed $value = null): mixed
    {
        return $this->options[$key] ?? null;
    }

    protected function mayThrow($value): void
    {
        if ($value instanceof ClientException) {
            throw $value;
        }
    }
}
