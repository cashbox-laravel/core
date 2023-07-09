# Sber Cashier Authorization Driver

<img src="https://preview.dragon-code.pro/cashier-provider/sber-auth-driver.svg?brand=laravel" alt="Sber Cashier Authorization Driver"/>

[![Stable Version][badge_stable]][link_packagist]
[![Unstable Version][badge_unstable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![License][badge_license]][link_license]

> **Note:** This driver doesn't need to be installed in the application. I's needed to implement [Sber](https://www.sberbank.ru/en) bank authorization for [Cashier](https://github.com/cashier-provider/core) drivers.

## Installation

To get the latest version of `Sber Cashier Authorization Driver`, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require cashier-provider/sber-auth
```

Or manually update `require` block of `composer.json` and run `composer update`.

```json
{
    "require": {
        "cashier-provider/sber-auth": "^2.0"
    }
}
```

## Using

```php
namespace CashierProvider\Sber\QrCode\Requests;

use CashierProvider\Core\Http\Request;
use CashierProvider\Sber\Auth\Auth;
use CashierProvider\Sber\QrCode\Constants\Body;
use CashierProvider\Sber\QrCode\Constants\Scopes;

class Create extends Request
{
    protected $path = '/ru/prod/order/v3/creation';

    // You need to provide a link to the authorization class:
    protected $auth = Auth::class;

    // You need to specify a scope to receive a token by auth:
    protected $auth_extra = [
        Body::SCOPE => Scopes::CREATE,
    ];
}
```

It's all. Enjoy 😎

[badge_downloads]:      https://img.shields.io/packagist/dt/cashier-provider/sber-auth.svg?style=flat-square

[badge_license]:        https://img.shields.io/packagist/l/cashier-provider/sber-auth.svg?style=flat-square

[badge_stable]:         https://img.shields.io/github/v/release/cashier-provider/sber-auth?label=stable&style=flat-square

[badge_unstable]:       https://img.shields.io/badge/unstable-dev--main-orange?style=flat-square

[link_license]:         LICENSE

[link_packagist]:       https://packagist.org/packages/cashier-provider/sber-auth
