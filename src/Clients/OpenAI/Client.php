<?php

namespace Asciito\SimpleGenerators\Clients\OpenAI;

use Asciito\SimpleGenerators\Clients\Contracts\Client as ClientContract;
use Asciito\SimpleGenerators\Clients\Exceptions\InvalidImageSize;
use Illuminate\Support\Collection;
use OpenAI\Contracts\ClientContract as OpenAIClientContract;

class Client implements ClientContract
{
    protected \Closure $clientResolver;

    protected Collection $options;

    protected array $dallE2ImageSizes = [
        '256-w' => '256x256',
        '512-w' => '512x512',
        '1024-w' => '1024x1024',
    ];

    protected array $dallE3ImageSizes = [
        '1024-w' => '1024x1024',
        '1792-w' => '1792x1024',
        '1792-h' => '1024x1792',
    ];

    public function __construct(array $options = [], \Closure $clientResolver = null)
    {
        $this->options = collect($options);

        $this->clientResolver = $clientResolver ?? fn (): OpenAIClientContract => \OpenAI::client($this->getOption('apiKey'));
    }

    #[\Override]
    public function generateImageFromPrompt(string $prompt, string $size = null): string
    {
        $response = $this->resolveClient()->images()->create([
            'model' => $this->getOption('image-model', 'dall-e-3'),
            'prompt' => $prompt,
            'n' => 1,
            'size' => $this->getImageSize($size),
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

    protected function getImageSize(string $size = null): string
    {
        $size ??= $this->getOption('image-size', '1024-w');
        $model = $this->getOption('image-model', 'dall-e-3');

        $sizes = match ($model) {
            'dall-e-2' => $this->dallE2ImageSizes,
            'dall-e-3' => $this->dallE3ImageSizes,
            default => ['1024-w' => '1024x1024'],
        };

        if (! array_key_exists($size, $sizes)) {
            $sizes = collect($this->dallE3ImageSizes)
                ->merge($this->dallE2ImageSizes)
                ->mapWithKeys(fn ($value, $key) => [$key => "'$key' => '$value'"])
                ->join(', ');

            throw new InvalidImageSize('open-ai', "The size you try to use [$size] is not valid, the valid sizes are: [$sizes]");
        }

        return $sizes[$size];
    }

    protected function resolveClient(): OpenAIClientContract
    {
        return call_user_func($this->clientResolver, $this->options);
    }
}
