<h1 align="center">Simple AI Generators</h1>

<p align="center">A very simple package to handle text and image generation from AI tools</p>
<p align="center">
    <a href="https://www.php.net/releases/index.php"><img src="https://img.shields.io/badge/php-^8.2-blue.svg" alt="Badge of the supported PHP versions"></a>
    <a href="./LICENSE.md"><img src="https://img.shields.io/badge/license-MIT-blue" alt="Badge for licence"></a>
    <a href="https://packagist.org/packages/asciito/simple-generators"><img src="https://img.shields.io/packagist/v/asciito/simple-generators.svg?style=flat-square" alt="Badge of current version"></a>
    <a href="https://github.com/asciito/simple-generators/actions/workflows/test.yml"><img src="https://github.com/asciito/simple-generators/actions/workflows/test.yml/badge.svg" alt="Badge to show if the test passed"></a>
</p>

---

## Description

The package is straightforward, enables you to generate either text or an
image, based on a text prompt, utilizing different AI providers.

---

## Get Started

> Requires [PHP ^8.2](https://www.php.net/releases/)

<br>

First, install `simple-generators` via [Composer](https://getcomposer.org/):

```shell
composer require asciito/simple-generators
```

And, that's all, you can start using the package without any problem.

---

## Usage

---

Our generator system (_text & image_) operates through `Clients`. These are classes implementing the
`\Asciito\SimpleGenerators\Providers\Contracts\Client` interface. You have the freedom to choose between
different clients or create your own.

- **Available Clients**: At the moment, only `OpenAI` is available.
- **Creating Your Own Client**: You have the option to develop your own clients. Please refer to the section [Create your own client](#create-your-own-client) for details on how to accomplish this.

In this documentation, our primary focus is on the `OpenAI` client.

### Generate Text with: `Factory::text(string $client = null, array $options = [])`

This section will guide you through the usage of the _text generator_ to create textual content.

```php
use Asciito\SimpleGenerators\Factory;

$generator = Factory::text(options: ['api' => 'this-is-a-key-for-open-ai']);

echo $generator->prompt('Give me a motivational phrase');

// for example: "Believe in yourself and all your dreams will come true".
```

### Generate Image with: `Factory::image(string $client = null, array $options = [])`

This section will guide you through the usage of the _image generator_ to crate images.

```php
use Asciito\SimpleGenerators\Factory;

$generator = Factory::image(options: ['api' => 'this-is-a-key-for-open-ai']);

echo $generator->prompt('A cat floating in space riding a horse with a France flag');

// For example, the URL might be: "https://oaidalleapiprodscus.blob.core.windows.net/private/rA23htPg4..."
```

> **Note**: If you omit the first parameter (in both static methods), the generator provider will fall back
> to `OpenAI` client, so be sure to give the correct options for the `OpenAI` [client](#open-ai).

### Create your own `client`

> This is a work in progress, because right now, there's no way to pass your class to the
> `text` or `image` generators

Put in simple words, you just need to implement the contract from `\Asciito\SimpleGenerator\Providers\Contracts\Client`,
this interface have 3 methods that should to be implemented.

```php
enerators\Clients\Contracts;

interface Client
{
    public function __construct(array $options = []);
    
    public function generateText(string $prompt): string;

    public function generateImage(string $prompt, string $size = null): string;
}
```

#### Method `__construct(array $options = [])`
The `__construct` method accepts a key-value array with the options that your client might use at some
point; the implementation is up to you.

#### Method `generateText(string $prompt)`
The `generateText` method accepts a string which is the text prompt that would be used to
make the request to your AI provider. It should return a string representing the response from your provider.

#### Method `generateImage(string $prompt, string $size = null)`
The `generateImage` method accepts a string which is the text prompt you should use to
make the request to your AI provider. However, you should ultimately return a string that represents
the response from your provider.

---

## Providers

List of every AI providers, and what options do they need to work.


### Open AI
The Open AI provider just requires one option, the `api` option, which will
be used to call the API and do its magic.

```php
$options = ['api' => 'this-is-your-api-key'];
```

This option should be passed to the `Factory::text` or `Factory::image` every time
you create a new `generator`.

---

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details