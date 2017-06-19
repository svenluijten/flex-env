![flex-env](https://cloud.githubusercontent.com/assets/11269635/12526309/85a09084-c16c-11e5-8099-cddf6f8fce78.jpg)

# Laravel FlexEnv

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Code Climate][ico-codeclimate]][link-codeclimate]
[![Code Quality][ico-quality]][link-quality]
[![StyleCI][ico-styleci]][link-styleci]

This package adds a handful of useful commands to edit your `.env` file in Laravel
directly from the command line with a simple, human readable API. Never touch the
mouse again!

## Installation
Via [composer](http://getcomposer.org):

```bash
$ composer require sven/flex-env --dev
```

Alternatively, add the package to your dev dependencies in `composer.json` and run
`composer update` afterwards:

```json
{
    "require-dev": {
        "sven/flex-env": "^2.0"
    }
}
```


**Note:** If you're using Laravel 5.5, you're done! The service provider is automatically registered in the container,
thanks to [auto-discovery](https://medium.com/@taylorotwell/package-auto-discovery-in-laravel-5-5-ea9e3ab20518).

Next, add the `FlexEnvServiceProvider` to your `providers` array in `config/app.php`:

```php
// config/app.php
'providers' => [
    ...
    Sven\FlexEnv\FlexEnvServiceProvider::class,
]
```

## Usage
The commands in this package should now be registered. Simply run `php artisan`,
and you will see them in the list.

```bash
# Create or edit an entry in your .env file:
$ php artisan env:set {key} {value} [--line-break|-L]
# Add the --line-break (or -L) option to insert a line break before the entry.
```

```bash
# Delete an entry from your .env file:
$ php artisan env:delete {key}
```

```bash
# Show the value of the given key from your .env file:
$ php artisan env:get {key}
```

```bash
# Show the entire .env file:
$ php artisan env:list
```

All changes you made should now be reflected in your `.env` file.

## Inspiration
Inspiration for this package came from [LeShadow's ArtisanExtended](https://github.com/LeShadow/ArtisanExtended).

## Contributing
All contributions (pull requests, issues and feature requests) are
welcome. Make sure to read through the [CONTRIBUTING.md](CONTRIBUTING.md) first,
though. See the [contributors page](../../graphs/contributors) for all contributors.

## License
`sven/flex-env` is licensed under the MIT License (MIT). See the [license file](LICENSE.md)
for more information.

[ico-version]: https://img.shields.io/packagist/v/sven/flex-env.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-green.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sven/flex-env.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/svenluijten/flex-env.svg?style=flat-square
[ico-codeclimate]: https://img.shields.io/codeclimate/github/svenluijten/flex-env.svg?style=flat-square
[ico-quality]: https://img.shields.io/scrutinizer/g/svenluijten/flex-env.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/49644781/shield

[link-packagist]: https://packagist.org/packages/sven/flex-env
[link-downloads]: https://packagist.org/packages/sven/flex-env
[link-travis]: https://travis-ci.org/svenluijten/flex-env
[link-codeclimate]: https://codeclimate.com/github/svenluijten/flex-env
[link-quality]: https://scrutinizer-ci.com/g/svenluijten/flex-env/?branch=master
[link-styleci]: https://styleci.io/repos/49644781
