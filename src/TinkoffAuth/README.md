# Tinkoff Cashier Authorization Driver

Tinkoff API Authorization Driver.

[![Stable Version][badge_stable]][link_packagist]
[![Unstable Version][badge_unstable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![License][badge_license]][link_license]

> **Note:** This driver doesn't need to be installed in the application. I's needed to implement [Tinkoff](https://www.tinkoff.ru/eng) bank authorization for [Cashier](https://github.com/cashier-provider/core) drivers.

## Installation

To get the latest version of `Tinkoff Auth Cashier Driver`, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require cashier-provider/tinkoff-auth
```

Or manually update `require` block of `composer.json` and run `composer update`.

```json
{
    "require": {
        "cashier-provider/tinkoff-auth": "^1.0"
    }
}
```

## Using

### Without Hashed Token

In some cases, for example, to initialize a payment session, it is necessary to transmit `terminal_key` and `terminal_secret` in clear text. In such cases, the `$hash = false`
parameter must be specified in the request.

```php
namespace CashierProvider\Tinkoff\QrCode\Requests;

use CashierProvider\Core\Http\Request;
use CashierProvider\Tinkoff\Auth\Auth;

class Init extends Request
{
    // You need to provide a link to the authorization class:
    protected $auth = Auth::class;

    protected $hash = false;
}
```

### With Hashed Token

In cases where the request must be signed with a special hashed token, you must set the `$hash` variable to `true`.

```php
namespace CashierProvider\Tinkoff\QrCode\Requests;

use CashierProvider\Core\Http\Request;
use CashierProvider\Tinkoff\Auth\Auth;

class Get extends Request
{
    protected $auth = Auth::class;

    protected $hash = true;
}
```

[badge_downloads]:      https://img.shields.io/packagist/dt/cashier-provider/tinkoff-auth.svg?style=flat-square

[badge_license]:        https://img.shields.io/packagist/l/cashier-provider/tinkoff-auth.svg?style=flat-square

[badge_stable]:         https://img.shields.io/github/v/release/cashier-provider/tinkoff-auth?label=stable&style=flat-square

[badge_unstable]:       https://img.shields.io/badge/unstable-dev--main-orange?style=flat-square

[link_license]:         LICENSE

[link_packagist]:       https://packagist.org/packages/cashier-provider/tinkoff-auth
