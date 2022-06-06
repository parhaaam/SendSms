


# The easiest way to send Sms inside your Laravel App

[![Latest Version on Packagist](https://img.shields.io/packagist/v/parhaaam/sendsms.svg?style=flat-square)](https://packagist.org/packages/parhaaam/sendsms)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/parhaaam/sendsms/run-tests?label=tests)](https://github.com/parhaaam/sendsms/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/parhaaam/sendsms/Check%20&%20fix%20styling?label=code%20style)](https://github.com/parhaaam/sendsms/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/parhaaam/sendsms.svg?style=flat-square)](https://packagist.org/packages/parhaaam/sendsms)

Easily send sms in laravel with any sms service provider.
## Supported Providers
| Provider   |
|------------|
| Kavenegar |
| SMS.IR |
## Installation

-install the package via composer:

```bash
composer require parhaaam/sendsms
```

-publish the config file with:

```bash
php artisan vendor:publish --tag="sendsms-config"
```

This is the contents of the published config file:

```php
return [

    'default' => 'kavenegar',
    'drivers' => [
        'kavenegar' => [
            'key'  => env('kavenegar_key', ''),
        ],
        'smsir' => [
            'key'    => env('smsir_key', ''),
            'secret' => env('smsir_key', ''),
        ]
    ]
];
```


## Usage

```php
// Send Lookup sms
$sendSms = new Parhaaam\SendSms();
$sendSms->sendLookup($receptor = "__phone_number__", $template = "loginVerify", $tokens = ["Test"]);

// Send Lookup sms with sms.ir
$sendSms = new SendSms();
$sendSms
    ->via('smsir')
    ->sendLookup($receptor = "__phone_number__", $template = "19737", ["token_one_name" => "token_value", "token_two_name" => "token_two_value"]);

```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Parham Parnian](https://github.com/parhaaam)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
