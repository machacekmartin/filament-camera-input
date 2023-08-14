# Camera input plugin for Filamentphp

[![Latest Version on Packagist](https://img.shields.io/packagist/v/machacekmartin/filament-camera-input.svg?style=flat-square)](https://packagist.org/packages/machacekmartin/filament-camera-input)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/machacekmartin/filament-camera-input/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/machacekmartin/filament-camera-input/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/machacekmartin/filament-camera-input/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/machacekmartin/filament-camera-input/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/machacekmartin/filament-camera-input.svg?style=flat-square)](https://packagist.org/packages/machacekmartin/filament-camera-input)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require machacekmartin/filament-camera-input
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-camera-input-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-camera-input-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-camera-input-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$filamentCameraInput = new Machacekmartin\FilamentCameraInput();
echo $filamentCameraInput->echoPhrase('Hello, Machacekmartin!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Martin](https://github.com/machacekmartin)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
