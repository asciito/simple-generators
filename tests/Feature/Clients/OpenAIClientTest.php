<?php


use Asciito\SimpleGenerators\Clients\OpenAI\Client;
use OpenAI\Responses\Chat\CreateResponse as ChatResponse;
use OpenAI\Responses\Images\CreateResponse as ImagesResponse;

it('generate text with Open AI', function () {
    $client = new OpenAI\Testing\ClientFake([
            ChatResponse::fake([
                'choices' => [[
                    'message' => [
                        'content' => 'Keep moving forward',
                    ]
                ]]
            ]),
        ]);

    $openAI = new Client(clientResolver: fn () => $client);

    $text = $openAI->generateTextFromPrompt('Give me a motivational phrase');

    $client->assertSent(\OpenAI\Resources\Chat::class, 1);

    expect($text)
        ->toBeString()
        ->not->toBeEmpty()
        ->toBe('Keep moving forward');
});


it('generate an image with Open AI', function () {
    $client = new OpenAI\Testing\ClientFake([
        ImagesResponse::fake([
            'data' => [[
                'url' => 'https://openai-fake-image.com/1000x1000/bHkVhpLZvOqnyfjSwvjzb67Bsmt47xDCwppAymwGHXrETdk4XWMFo4qQmA0GXaaz'
            ]]
        ]),
    ]);

    $openAI = new Client(clientResolver: fn () => $client);

    $url = $openAI->generateImageFromPrompt('Give me a motivational phrase');

    $client->assertSent(\OpenAI\Resources\Images::class, 1);

    expect($url)
        ->toBeString()
        ->not->toBeEmpty()
        ->toBeUrl();
});
