# Simple AI Generators

A very simple package to handle text and image generation from AI tools

---

![PHP Version](https://img.shields.io/badge/php-%3E%3D%208.2-blue.svg)
![MIT License Badge](https://img.shields.io/badge/license-MIT-blue)
![version](https://img.shields.io/badge/version-v0.1.0-blue)

## Description

The package is straightforward, enables you to generate either text or an
image, based on a text prompt, utilizing various AI providers.

---

## Get Started

> Requires [PHP 8.2+](https://www.php.net/releases/)

First, install simple-generators via [Composer](https://getcomposer.org/):

```shell
composer require asciito/simple-generators
```

And, that's all, you can start using the package without any problem.



---

## Usage

---

Our generator system (_text & image_) operates through `Clients`. These are classes implementing the
`\Asciito\SimpleGenerators\Clients\Contracts\Client` interface. You have the freedom to choose between
different clients or create your own. Right now, the only available client is `OpenAI`.

- **Available Clients**: At the moment, only `OpenAI` is available.
- **Creating Your Own Client**: You have the option to develop your own clients. Please refer to the section [Create your own client](#create-your-own-client) for details on how to accomplish this.

In this documentation, our primary focus is on the `OpenAI` client.

### Text Generator

This section will guide you through the usage of TextGenerator to create textual content.

```php
use Asciito\SimpleGenerators\Generators\TextGenerator;

$generator = TextGenerator::make(
    'open-ai',
    ['apiKey' => 'this-is-a-key-for-open-ai'],
);

$generator->prompt('Give me a motivational phrase');
// for example: "Believe in yourself and all your dreams will come true".
```

### Image Generator

This section will guide you through the ImageGenerator usage for generating images.

```php
use Asciito\SimpleGenerators\Generators\ImageGenerator;

$generator = ImageGenerator::make(
    'open-ai',
    ['apiKey' => 'this-is-a-key-for-open-ai'],
);

$generator->prompt('A cat floating in space riding a horse with a France flag');
// For instance, the URL might be: "https://oaidalleapiprodscus.blob.core.windows.net/private/rA23htPg4..."
```

### Create your own `client`

Put in simple words, you just need to implement the contract from `\Asciito\SimpleGenerator\Clients\Contracts\Client`
this interface have 4 methods that needs to be implemented.

```php
enerators\Clients\Contracts;

interface Client
{
    public function __construct(array $options = []);

    public function generateImageFromPrompt(string $prompt): string;

    public function generateTextFromPrompt(string $prompt): string;

    public function getOption(string $key, mixed $value = null): mixed;
}
```

#### Method `__construct(array $options = [])`
The `__construct` method accepts a key-value array with the options that your client might use at some
point; the implementation is up to you.

#### Method `generateImageFromPrompt(string $prompt)`
The `generateImageFromPrompt` method accepts a string which is the text prompt you should use to
make the request to your AI provider. However, you should ultimately return a string that represents
the response from your provider.

#### Method `generateTextFromPrompt(string $prompt)`
The `generateTextFromPrompt` method accepts a string which is the text prompt that would be used to
make the request to your AI provider. It should return a string representing the response from your provider.

#### Method `getOption(string $key, mixed $value = null)`
The `getOption` method accepts a key and an optional default value. It is used to get an option
from the options array that was passed during the instantiation of the client. If the key is
not found in the options array, it should return the provided default value.


> **Note**:
> If for some reason your AI provider returns an error or throws an exception, you need to catch
> it, process it, and then throw a new **exception**. This **exception** class should implement
> the class `\Asciito\SimpleGenerators\Clients\Contracts\Exception\ClientException`.
---

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details