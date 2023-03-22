# A Laravel wrapper around Symfony Serializer

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mochaka/laravel-serializer.svg?style=flat-square)](https://packagist.org/packages/mochaka/laravel-serializer)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/mochaka/laravel-serializer/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/mochaka/laravel-serializer/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/mochaka/laravel-serializer/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/mochaka/laravel-serializer/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mochaka/laravel-serializer.svg?style=flat-square)](https://packagist.org/packages/mochaka/laravel-serializer)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.


## Installation

You can install the package via composer:

```bash
composer require mochaka/laravel-serializer
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-serializer-config"
```

## Usage

```php
    $myObject = new MyObject(['data' => []]);

    $serialized = LaravelSerializer::serialize($myObject, 'json');

    $myObject = LaravelSerializer::deserialize($myObject, MyObject::class, 'json');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Aaron Florey](https://github.com/aaronflorey)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
