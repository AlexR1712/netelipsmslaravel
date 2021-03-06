# Netelip SMS Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/alexr1712/netelipsmslaravel.svg?style=flat-square)](https://packagist.org/packages/alexr1712/netelipsmslaravel)
[![Build Status](https://img.shields.io/travis/alexr1712/netelipsmslaravel/master.svg?style=flat-square)](https://travis-ci.org/alexr1712/netelipsmslaravel)
[![Quality Score](https://img.shields.io/scrutinizer/g/alexr1712/netelipsmslaravel.svg?style=flat-square)](https://scrutinizer-ci.com/g/alexr1712/netelipsmslaravel)
[![Total Downloads](https://img.shields.io/packagist/dt/alexr1712/netelipsmslaravel.svg?style=flat-square)](https://packagist.org/packages/alexr1712/netelipsmslaravel)

Netelip SMS Service for Laravel 8+

## Installation

You can install the package via composer:

```bash
composer require alexr1712/netelipsmslaravel
```

```bash
php artisan vendor:publish --provider="AlexR1712\NetelipLaravel\NetelipLaravelServiceProvider" --tag="config"
```

> Set token on config/netelip-laravel.php

## Usage

``` php
use AlexR1712\NetelipLaravel\NetelipLaravel;
$sms = new NetelipLaravel;

$sms->send('0058424XXXXXXX', 'Message Here');
/*
send method return the following 

[
     "is_sent" => true,
     "sms_id" => "1613770552.2529",
     "statusCode" => 200,
     "remainingBalance" => 4.602,
]
*/
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email alexr1712@gmail.com instead of using the issue tracker.

## Credits

- [Alexander Rodriguez](https://github.com/alexr1712)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
