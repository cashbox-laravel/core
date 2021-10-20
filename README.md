# Laravel Cashier Provider

Cashier provides an expressive, fluent interface to manage billing services.

[![Stable Version][badge_stable]][link_packagist]
[![Unstable Version][badge_unstable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![License][badge_license]][link_license]

## Installation

To get the latest version of `Laravel Cashier Provider`, simply require the project using [Composer](https://getcomposer.org):

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

You should publish the config file and migrations with:

```bash
php artisan vendor:publish --provider="Helldar\Cashier\ServiceProvider"
```

Further, if necessary, edit the migration file copied to your application and run the command to apply migrations:

```bash
php artisan migrate
```

## Using

> [`Cashier`](https://github.com/andrey-helldar/cashier) allows you to connect any payment driver compatible with your application.
>
> Depending on the type of payment, Cashier will automatically call the required driver to work with the bank's API.


### Configuration

Before starting, edit the [config/cashier.php](https://github.com/andrey-helldar/cashier/blob/main/config/cashier.php) file:

```php
use App\Models\Payment as Model;
use Helldar\Cashier\Constants\Attributes;
use Helldar\Cashier\Constants\Status;

return [
    'payment' => [

        // Please provide a link to the payment model.
        'model' => App\Models\Payment::class,

        // Specify the field names for the payment types based on which
        // the required driver will be loaded, the status identifier and
        // the entry creation date fields.
        'attributes' => [
            Attributes::TYPE => 'type_id',

            Attributes::STATUS => 'status_id',

            Attributes::CREATED_AT => 'created_at',
        ],

        // Indicate the correspondence of statuses in your system.
        // Values can be either integer or string.
        'statuses' => [
            Status::NEW => Model::STATUS_NEW,

            Status::SUCCESS => Model::STATUS_SUCCESS,

            Status::FAILED => Model::STATUS_FAILED,

            Status::REFUND => Model::STATUS_REFUND,

            Status::WAIT_REFUND => Model::STATUS_WAIT_REFUND,
        ],

        // Here you need to specify the name of the drivers called
        // for the payment types.
        'map' => [
            Model::PAYMENT_TYPE_QR_SBER => 'driver_name',
        ],
    ],

    // This parameter determines in which queue workers will be sent for
    // requests to banks.
    'queue' => [

        // This value indicates which queue service the jobs will fall into.
        // Here you may define a default connection.
        'connection' => env('QUEUE_CONNECTION'),

        // This value specifies the names of the queue into which the task will
        // be placed.
        'names' => [
            'start' => env('CASHIER_QUEUE'),
            'check' => env('CASHIER_QUEUE'),
            'refund' => env('CASHIER_QUEUE'),
        ],
    ],

    // This parameter defines the parameters for automatic refunds.
    'auto_refund' => [

        // This setting determines whether you want to issue an automatic refund
        // of payments.
        'enabled' => env('CASHIER_AUTO_REFUND_ENABLED', false),
    ],

    // This setting defines the list of drivers for the implementation of
    // payments.
    'drivers' => [
        'driver_name' => [

            // Here you need to fill in the data of the connected payment driver
            // Connection information is usually found in the driver documentation.

        ]
    ]
];
```

### Using Trait

Add the necessary trait to your Payment model:

```php
namespace App\Models;

use Helldar\Cashier\Concerns\Casheable;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use Casheable;
}
```

### Cron Commands

You need to register a call to the console command to periodically start checking payment statuses.

Add a call to `app/Console/Kernel.php` file:

```php
use Illuminate\Console\Scheduling\Schedule;

protected function schedule(Schedule $schedule)
{
    $schedule->command('cashier:check')->withoutOverlapping()->everyThirtyMinutes();
    $schedule->command('cashier:refund')->withoutOverlapping()->daily();
}
```

* `cashier:check` - Launching a re-verification of payments with a long processing cycle.
* `cashier:refund` - Launching the command to check payments for refunds.

You can specify any start time for the `cashier:check` command, but we recommend using the call every thirty minutes.

> **Note:** we do not recommend calling the command every 15 minutes or more often - this can fill up the task queue and delay the processing of new items.


### Queue Handler

If your application uses a queue handler (we hope you are using it), then you will need to add configuration to it.

This must be done if you give it your connection and names.

For example:

```ini
[program:queue-payments]
process_name = %(process_num)02d
command = php /var/www/artisan queue:work database --queue=payments_start,payments_check,payments_refund
autostart = true
autorestart = true
numprocs = 4
user = www-data
redirect_stderr = true
stdout_logfile = /var/www/storage/logs/queue-payments.log
```

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

## Drivers

### Available

| Driver | Description |
|:---|:---|
| [andrey-helldar/cashier-sber-qr](https://github.com/andrey-helldar/cashier-sber-qr) | Driver for payment with QR codes via Sber |
| [andrey-helldar/cashier-tinkoff-qr](https://github.com/andrey-helldar/cashier-tinkoff-qr) | Driver for payment with QR codes via Tinkoff |

#### Authorization drivers

| Driver | Description |
|:---|:---|
| [andrey-helldar/cashier-sber-auth](https://github.com/andrey-helldar/cashier-sber-auth) | Sber API Authorization Driver |
| [andrey-helldar/cashier-tinkoff-auth](https://github.com/andrey-helldar/cashier-tinkoff-auth) | Tinkoff API Authorization Driver |

### Development

Create main classes with the following inheritance:

| Class | Extends | Description
|:---|:---|:---|
| `Driver` | `Helldar\Cashier\Services\Driver` | Main driver file. Contains information on exchanging information with the bank via the API. |
| `Exceptions\Manager` | `Helldar\Cashier\Exceptions\Manager` | Error handling manager. Contains information about error codes returned from the bank. |
| `Helpers\Statuses` | `Helldar\Cashier\Services\Statuses` | Types of statuses. Groups the statuses returned by the bank by type. |
| `Resources\Details` | `Helldar\Cashier\Resources\Details` | Details cast. Contains information for working with the bank. For example, in the [`andrey-helldar/cashier-sber-qr`](https://github.com/andrey-helldar/cashier-sber-qr) driver, it contains a link to generate a QR code. In your driver, you are free to specify the methods you need. |
| `Requests\Create` | `Helldar\Cashier\Http\Request` | Request to the bank to initiate a payment session. |
| `Requests\Status` | `Helldar\Cashier\Http\Request` | Request to the bank to check the status of the payment. |
| `Requests\Cancel` | `Helldar\Cashier\Http\Request` | Request to the bank to cancel the payment and return the funds to the client if he has already paid for the services. |
| `Responses\Created`, `Responses\Refund`, `Responses\Status` | `Helldar\Cashier\Http\Response` | Classes for processing responses from the bank. |

```php
namespace YourName\CashierDriver\BankName\BankTechnology;

use Helldar\Cashier\Services\Driver as BaseDriver;
use Helldar\Contracts\Cashier\Http\Response;
use YourName\CashierDriver\BankName\BankTechnology\Exceptions\Manager;
use YourName\CashierDriver\BankName\BankTechnology\Helpers\Statuses;
use YourName\CashierDriver\BankName\BankTechnology\Requests\Cancel;
use YourName\CashierDriver\BankName\BankTechnology\Requests\Create;
use YourName\CashierDriver\BankName\BankTechnology\Requests\Status;
use YourName\CashierDriver\BankName\BankTechnology\Resources\Details;
use YourName\CashierDriver\BankName\BankTechnology\Responses\Created;
use YourName\CashierDriver\BankName\BankTechnology\Responses\Refund;
use YourName\CashierDriver\BankName\BankTechnology\Responses\Status as StatusResponse;

class Driver extends BaseDriver
{
    protected $exceptions = Manager::class;

    protected $statuses = Statuses::class;

    protected $details = Details::class;

    public function start(): Response
    {
        $request = Create::make($this->model);

        return $this->request($request, Created::class);
    }

    public function check(): Response
    {
        $request = Status::make($this->model);

        return $this->request($request, StatusResponse::class);
    }

    public function refund(): Response
    {
        $request = Cancel::make($this->model);

        return $this->request($request, Refund::class);
    }
}
```

These are the main files for driver development.

For convenience, we have created a [`Cashier Driver Template`](https://github.com/CashierProvider/driver-template), on the basis of which you can create your own driver. And also
the [`Cashier Authorization Driver Template`](https://github.com/CashierProvider/driver-auth-template).


## For Enterprise

Available as part of the Tidelift Subscription.

The maintainers of `andrey-helldar/cashier` and thousands of other packages are working with Tidelift to deliver commercial support and maintenance for the open source packages you
use to build your applications. Save time, reduce risk, and improve code health, while paying the maintainers of the exact packages you
use. [Learn more](https://tidelift.com/subscription/pkg/packagist-andrey-helldar-cashier?utm_source=packagist-andrey-helldar-cashier&utm_medium=referral&utm_campaign=enterprise&utm_term=repo)
.

[badge_downloads]:      https://img.shields.io/packagist/dt/andrey-helldar/cashier.svg?style=flat-square

[badge_license]:        https://img.shields.io/packagist/l/andrey-helldar/cashier.svg?style=flat-square

[badge_stable]:         https://img.shields.io/github/v/release/andrey-helldar/cashier?label=stable&style=flat-square

[badge_unstable]:       https://img.shields.io/badge/unstable-dev--main-orange?style=flat-square

[link_license]:         LICENSE

[link_packagist]:       https://packagist.org/packages/andrey-helldar/cashier
