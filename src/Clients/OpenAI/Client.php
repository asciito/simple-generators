<?php

namespace Asciito\SimpleGenerators\Clients\OpenAI;

use Asciito\SimpleGenerators\Clients\Contracts\Client as ClientContract;
use Illuminate\Support\Collection;
use OpenAI\Contracts\ClientContract as OpenAIClientContract;

class Client implements ClientContract
{
    protected \Closure $clientResolver;

    protected Collection $options;

    public function __construct(array $options = [], \Closure $clientResolver = null)
    {
        $this->options = collect($options);

        $this->clientResolver = $clientResolver ?? fn (): OpenAIClientContract => \OpenAI::client($this->getOption('apiKey'));
    }

    #[\Override]
    public function generateImageFromPrompt(string $prompt): string
    {
        $response = $this->resolveClient()->images()->create([
            'model' => $this->getOption('image-model', 'dall-e-3'),
            'prompt' => $prompt,
            'n' => 1,
            'size' => '1000x1000',
        ]);

        return $response->data[0]->url;
    }

    #[\Override]
    public function generateTextFromPrompt(string $prompt): string
    {
        $response = $this->resolveClient()->chat()->create([
            'model' => $this->getOption('text-model', 'gpt-3.5-turbo'),
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt,
                ]
            ]
        ]);

        return $response->choices[0]->message->content;
    }

    #[\Override]
    public function getOption(string $key, mixed $value = null): mixed
    {
        return $this->options->get($key, $value);
    }

    protected function resolveClient(): OpenAIClientContract
    {
        return call_user_func($this->clientResolver, $this->options);
    }
}
