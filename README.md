![flex-env](https://cloud.githubusercontent.com/assets/11269635/12333265/7e4a8620-baf3-11e5-8baf-0df225a3d481.jpg)

# Laravel FlexEnv

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]

This package adds a handful of useful commands to edit your `.env` file in Laravel
directly from the command line with a simple, human readable API. Never touch the
mouse again!

## Installation
Via [composer](http://getcomposer.org):

```bash
$ composer require sven/flex-env:~2.0
```

Next, add the `FlexEnvServiceProvider` to your `providers` array in `config/app.php`:

```php
// config/app.php
'providers' => [
    ...
    Sven\FlexEnv\FlexEnvServiceProvider::class,
    ...
];
```

## Usage
The commands in this package should now be registered. Simply run `php artisan`,
and you will see them in the list.

```bash
# Set a key/value in your .env file:
$ php artisan env:set {key} {value}
# (if the value can not be found, it will be created)

# Delete a key/value pair from your .env file:
$ php artisan env:delete {key}

# Show the value for the given key from your .env file:
$ php artisan env:get {key}

# Show the entire .env file.
$ php artisan env:list
```

All changes you made should now be reflected in your `.env` file.

## Contributing
Inspiration for this package came from [LeShadow's ArtisanExtended](https://github.com/LeShadow/ArtisanExtended).

All contributions (in the form on pull requests, issues and feature-requests) are
welcomed and will be properly credited.

## License
`sven/flex-env` is licenced under the MIT License (MIT). Please see the
[license file](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/sven/flex-env.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-green.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sven/flex-env.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/USER/REPO.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/sven/flex-env
[link-downloads]: https://packagist.org/packages/sven/flex-env
[link-travis]: https://travis-ci.org/svenluijten/flex-env