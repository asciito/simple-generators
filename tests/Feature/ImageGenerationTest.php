<?php

declare(strict_types=1);

use Asciito\SimpleGenerators\Generators\ImageGenerator;

beforeEach(fn () => \Asciito\SimpleGenerators\Factory::flushFakeGenerator());

it('generate an image', function () {
    \Asciito\SimpleGenerators\Factory::fake(
        ImageGenerator::fake([
            'https://fake-ai-provider.com/this-is-a-fake-url',
        ]),
    );

    expect('Draw me an ant waling in the desert')
        ->generateImage();
});

it('generate a couple of images', function () {
    \Asciito\SimpleGenerators\Factory::fake(
        ImageGenerator::fake([
            'https://fake-ai-provider.com/this-is-a-fake-url',
            'https://fake-ai-provider.com/this-is-another-fake-url',
        ])
    );

    expect('Draw me a cat in space')
        ->generateImage()
    ->and('Draw me a bunch of dogs playing card, smocking and drinking')
        ->generateImage();
});
