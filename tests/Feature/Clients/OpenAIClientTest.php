<?php

test('text generation', function () {
    $fake = new \OpenAI\Testing\ClientFake([
        \OpenAI\Responses\Chat\CreateResponse::fake([
            'choices' => [[
                'message' => [
                    'content' => 'This is a fake song...',
                ]
            ]]
        ]),
    ]);

    $client = new \Asciito\SimpleGenerators\Providers\OpenAI(['api' => 'this-is-a-fake-api-key']);

    $client->setClient($fake);

    $text = $client->generateText('Write a song');

    expect($text)
        ->toBeString()
        ->not()->toBeEmpty()
        ->toBe('This is a fake song...');
});

test('image generation', function () {
    $fake = new \OpenAI\Testing\ClientFake([
        \OpenAI\Responses\Images\CreateResponse::fake([
            'data' => [[
                'url' => 'https://fake-open-ai.com/this-is-a-fake-url-from-open-ai',
            ]],
        ]),
    ]);

    $client = new \Asciito\SimpleGenerators\Providers\OpenAI(['api' => 'this-is-a-fake-api-key']);

    $client->setClient($fake);

    $url = $client->generateImage('Draw a dog running a marathon in space');

    expect($url)
        ->toBeString()
        ->not()->toBeEmpty()
        ->toBeUrl();
});
