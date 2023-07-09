# Cash Driver Provider

<img src="https://preview.dragon-code.pro/cashier-provider/cash.svg?brand=laravel&mode=dark" alt="Cash Driver"/>

[![Stable Version][badge_stable]][link_packagist]
[![Unstable Version][badge_unstable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![License][badge_license]][link_license]


## Installation

To get the latest version of `Cash Driver Provider`, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require cashier-provider/cash
```

Or manually update `require` block of `composer.json` and run `composer update`.

```json
{
    "require": {
        "cashier-provider/cash": "^2.0"
    }
}
```

## Using

> **Note**:
>
> This project is the driver for [`Cashier Provider`](https://github.com/cashier-provider/core).


### Configuration

Add your driver information to the `config/cashier.php` file:

```php
use App\Models\Payment;
use App\Payments\Cash as CashDetails;
use CashierProvider\Cash\Driver as CashDriver;
use CashierProvider\Core\Constants\Driver;

return [
    'payment' => [
        'map' => [
            Payment::TYPE_CASH => 'cash'
        ]
    ],

    'drivers' => [
        'cash' => [
            Driver::DRIVER  => CashDriver::class,
            Driver::DETAILS => CashDetails::class,
        ]
    ]
];
```

### Resource

Create a model resource class inheriting from `CashierProvider\Core\Resources\Model` in your application.

Use the `$this->model` link to refer to the payment model. When executed, the `$model` parameter will contain the payment instance.

```php
namespace App\Payments;

use CashierProvider\Core\Resources\Model;

class Cash extends Model
{
    protected function paymentId(): string
    {
        return (string) $this->model->id;
    }

    protected function sum(): float
    {
        return (float) $this->model->sum;
    }

    protected function currency(): int
    {
        return $this->model->currency;
    }

    protected function createdAt(): Carbon
    {
        return $this->model->created_at;
    }
}
```

### Available Methods And Details Data

```php
$payment->cashier->external_id
// Returns transaction ID for this operation

$payment->cashier->details->getStatus(): ?string
// Returns the text status from the bank
// For example, `PAID`.

$payment->cashier->details->toArray(): array
// Returns an array of status.
// For example,
//
// [
//     'status' => 'PAID'
// ]
```

[badge_downloads]:      https://img.shields.io/packagist/dt/cashier-provider/cash.svg?style=flat-square

[badge_license]:        https://img.shields.io/packagist/l/cashier-provider/cash.svg?style=flat-square

[badge_stable]:         https://img.shields.io/github/v/release/cashier-provider/cash?label=stable&style=flat-square

[badge_unstable]:       https://img.shields.io/badge/unstable-dev--main-orange?style=flat-square

[link_license]:         LICENSE

[link_packagist]:       https://packagist.org/packages/cashier-provider/cash
