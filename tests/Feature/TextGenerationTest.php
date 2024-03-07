<?php

use Asciito\SimpleGenerators\Clients\ClientFakeException;
use Asciito\SimpleGenerators\Generators\TextGenerator;

it('generate text from a fake client', function () {
    $client = TextGenerator::fakeClient([
        'text' => [
            'Keep moving forward!',
        ],
    ]);

    $generator = TextGenerator::make('fake', client: $client);

    $text = $generator->prompt('Give me a motivational phrase');

    expect($text)
        ->toBeString()
        ->not->toBeEmpty()
        ->toBe('Keep moving forward!');
});

test('AI client not found')
    ->expect(fn () => TextGenerator::make('unknown'))
    ->throws('The client [unknown] does not exists');

test('AI client throws an exception', function () {
    $client = TextGenerator::fakeClient([
        'text' => [
            ClientFakeException::make('fake', 'This is a custom exception'),
        ],
    ]);

    $generator = TextGenerator::make('throwable', client: $client);

    $generator->prompt('This is just a fake prompt');
})->throws('This is a custom exception');
