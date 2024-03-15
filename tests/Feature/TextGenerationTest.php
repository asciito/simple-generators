<?php

declare(strict_types=1);

use Asciito\SimpleGenerators\Generators\TextGenerator;

beforeEach(fn () => \Asciito\SimpleGenerators\Factory::flushFakeGenerator());

it('generate a simple text', function () {
    \Asciito\SimpleGenerators\Factory::fake(
        TextGenerator::fake([
            'This is a short story',
        ]),
    );

    expect('Tell me a short story')
        ->generateTextEqual('This is a short story');
});

it('generate a couple of text', function () {
    \Asciito\SimpleGenerators\Factory::fake(
        TextGenerator::fake([
            "I'm a fake AI provider",
            'The earth is 4.543 billion years',
        ])
    );

    expect('Who are you?')
        ->generateTextEqual("I'm a fake AI provider")
    ->and('How old is the planet earth?')
        ->generateTextEqual('The earth is 4.543 billion years');
});
