# Cashier

Cashier provides an expressive, fluent interface to manage billing services.

[![Stable Version][badge_stable]][link_packagist]
[![Unstable Version][badge_unstable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![License][badge_license]][link_license]

## Installation

To get the latest version of `Cashier`, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require andrey-helldar/cashier
```

Or manually update `require` block of `composer.json` and run `composer update`.

```json
{
    "require": {
        "andrey-helldar/cashier": "^1.0"
    }
}
```

You should publish the [config/cashier.php](https://github.com/andrey-helldar/cashier/blob/main/config/cashier.php) config file with:

```bash
php artisan vendor:publish --provider="Helldar\Cashier\ServiceProvider"
```

Next, run the migrations:

```bash
php artisan migrate
```

## Using

Before starting, fill in the [config/cashier.php](https://github.com/andrey-helldar/cashier/blob/main/config/cashier.php) file published in the app:

```php
use App\Models\Payment as Model;
use Helldar\Cashier\Constants\Status;

return [
    'payments' => [
        'model' => App\Models\Payment::class,

        'attributes' => [
            'type'     => 'type_id',
            'status'   => 'status_id',
            'sum'      => 'sum',
            'currency' => 'currency'
        ],

        'statuses' => [
            Status::NEW => Model::STATUS_NEW,

            Status::SUCCESS => Model::STATUS_SUCCESS,

            Status::FAILED => Model::STATUS_FAILED,

            Status::REFUND => Model::STATUS_REFUND,

            Status::WAIT_REFUND => Model::STATUS_WAIT_REFUND,
        ],

        'assign_drivers' => [
            Model::PAYMENT_TYPE_QR_SBERBANK => 'sber_qr',
        ],
    ],

    'queue' => env('CASHIER_QUEUE', 'payments'),
];
```

Add the necessary trait to your Payment model:

```php
use Helldar\Cashier\Concerns\Casheable;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use Casheable;
}
```

If you need to specify different pairs of client id and client secret, depending on any conditions, you can add a public method `cashierAuth` to the Payment
model:

```php
use Helldar\Cashier\Concerns\Casheable;
use Helldar\Cashier\Contracts\Auth as AuthContract;
use Helldar\Cashier\DTO\Auth;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use Casheable;

    public function cashierAuth(): AuthContract
    {
        $settings = $this->order->unit->settings;

        return Auth::make()
            ->setClientId($settings->client_id)
            ->setClientSecret($settings->client_secret);
    }
}
```

### Schedule command

You need to register a call to the console command to periodically start checking payment statuses.

Add a call to `app/Console/Kernel.php` file:

```php
use Illuminate\Console\Scheduling\Schedule;

protected function schedule(Schedule $schedule)
{
    $schedule->command('cashier:check')->withoutOverlapping()->hourlyAt(12);
}
```

You can specify any start time, but we recommend using the call every hour.

> **Note:** we do not recommend calling the command every 30 minutes or more often - this can fill up the task queue and delay the processing of new items.

### Manual

```php
use App\Models\Payment;
use Helldar\Cashier\Services\Jobs;

$model = Payment::findOrfail(1234);

$jobs = Jobs::make($model);

$jobs->start();
$jobs->check();
$jobs->refund();
$jobs->retry();
```

Also, you can use the console commands:

```bash
php artisan cashier:check
php artisan cashier:refund {payment_id}
```

## Drivers

| Driver | Description |
|:---|:---|
| [andrey-helldar/cashier-sber-qr](https://github.com/andrey-helldar/cashier-sber-qr) | Driver for payment with QR codes via Sber |
| [andrey-helldar/cashier-tinkoff-qr](https://github.com/andrey-helldar/cashier-tinkoff-qr) | Driver for payment with QR codes via Tinkoff |

## For Enterprise

Available as part of the Tidelift Subscription.

The maintainers of `andrey-helldar/cashier` and thousands of other packages are working with Tidelift to deliver commercial support and maintenance for the open
source packages you use to build your applications. Save time, reduce risk, and improve code health, while paying the maintainers of the exact packages you
use. [Learn more](https://tidelift.com/subscription/pkg/packagist-andrey-helldar-cashier?utm_source=packagist-andrey-helldar-cashier&utm_medium=referral&utm_campaign=enterprise&utm_term=repo)
.

[badge_downloads]:      https://img.shields.io/packagist/dt/andrey-helldar/cashier.svg?style=flat-square

[badge_license]:        https://img.shields.io/packagist/l/andrey-helldar/cashier.svg?style=flat-square

[badge_stable]:         https://img.shields.io/github/v/release/andrey-helldar/cashier?label=stable&style=flat-square

[badge_unstable]:       https://img.shields.io/badge/unstable-dev--main-orange?style=flat-square

[link_license]:         LICENSE

[link_packagist]:       https://packagist.org/packages/andrey-helldar/cashier
