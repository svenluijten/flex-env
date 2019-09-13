![flex-env](https://cloud.githubusercontent.com/assets/11269635/12526309/85a09084-c16c-11e5-8099-cddf6f8fce78.jpg)

# Laravel FlexEnv
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-build]][link-build]
[![StyleCI][ico-styleci]][link-styleci]

This package allows you to create, show, edit, update, and delete entries in
your `.env` file in a Laravel project via `php artisan`, the command line
we all know and love.

## Index
- [Installation](#installation)
  - [Downloading](#downloading)
  - [Registering the service provider](#registering-the-service-provider)
- [Usage](#usage)
  - [Create or edit an entry](#create-or-edit-an-entry)
  - [Delete an entry](#delete-an-entry)
  - [Inspect an entry](#inspect-an-entry)
  - [List all entries](#list-all-entries)
- [Inspiration](#inspiration)
- [Contributing](#contributing)
- [License](#license)

## Installation
You'll have to follow a couple of simple steps to install this package.

### Downloading
Via [composer](http://getcomposer.org):

```bash
$ composer require sven/flex-env:^3.0 --dev
```

Or add the package to your development dependencies in `composer.json` and run
`composer update sven/flex-en` to download the package:

```json
{
    "require-dev": {
        "sven/flex-env": "^3.0"
    }
}
```

### Registering the service provider
If you're using Laravel 5.5, you can skip this step. The service provider will have already been registered
thanks to auto-discovery. 

Otherwise, register `Sven\FlexEnv\ServiceProvider::class` manually in your `AppServiceProvider`'s
`register` method:

```php
public function register()
{
    if ($this->app->environment() !== 'production') {
        $this->app->register(\Sven\FlexEnv\ServiceProvider::class);
    }    
}
```

## Usage
The commands in this package should now be registered. If you now run `php artisan`,
you'll see them in the list:

- `env:set`
- `env:delete`
- `env:get`
- `env:list`

### Create or edit an entry
```bash
$ php artisan env:set NEW_KEY "your key's value"
```

You can use the `--after` flag to specify where in the `.env` file the entry should go:

```bash
$ php artisan env:set NEW_KEY "your key's value" --after=APP_URL
```

If the environment variable `APP_URL` doesn't exist, the new variable will be added to
the end of the file.

### Delete an entry
```bash
$ php artisan env:delete SOME_KEY
```

This will ask for your confirmation. If you want to remove the entry without being asked,
use the `--force` flag: 

```bash
$ php artisan env:delete SOME_KEY --force
```

### Inspect an entry
```bash
$ php artisan env:get SOME_KEY
```

### List all entries
```bash
$ php artisan env:list
```

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
[ico-build]: https://img.shields.io/travis/svenlujten/flex-env?style=flat-square
[ico-styleci]: https://styleci.io/repos/49644781/shield

[link-packagist]: https://packagist.org/packages/sven/flex-env
[link-downloads]: https://packagist.org/packages/sven/flex-env
[link-build]: https://travis-ci.org/svenluijten/flex-env
[link-styleci]: https://styleci.io/repos/49644781
