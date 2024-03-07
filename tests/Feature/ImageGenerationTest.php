<?php

use Asciito\SimpleGenerators\Clients\ClientFakeException;
use Asciito\SimpleGenerators\Generators\ImageGenerator;

it('generate text from a fake client', function () {
    $client = ImageGenerator::fakeClient([
        'image' => [
            'https://fake.pictures/1366x768',
        ],
    ]);

    $generator = ImageGenerator::make('fake', client: $client);

    $url = $generator->prompt('Give me a motivational phrase');

    expect($url)
        ->toBeString()
        ->not->toBeEmpty()
        ->toBeUrl();
});

test('AI client not found')
    ->expect(fn () => ImageGenerator::make('unknown'))
    ->throws('The client [unknown] does not exists');

test('AI client throws an exception', function () {
    $client = ImageGenerator::fakeClient([
        'image' => [
            ClientFakeException::make('fake', 'This is a custom exception'),
        ],
    ]);

    $generator = ImageGenerator::make('throwable', client: $client);

    $generator->prompt('You should give me a fake image');
})->throws('This is a custom exception');
