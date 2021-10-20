# Laravel Cashier Provider

Cashier provides an expressive, fluent interface to manage billing services.

[![Stable Version][badge_stable]][link_packagist]
[![Unstable Version][badge_unstable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![License][badge_license]][link_license]

## Installation

> Note
>
> Drivers will usually automatically install the correct `Cashier Provider Core` version, but you can do this manually.

To get the latest version of `Laravel Cashier Provider`, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require cashier-provider/core
```

Or manually update `require` block of `composer.json` and run `composer update`.

```json
{
    "require": {
        "cashier-provider/core": "^1.0"
    }
}
```

You should publish the config file and migrations with:

```bash
php artisan vendor:publish --provider="CashierProvider\Core\ServiceProvider"
```

Further, if necessary, edit the migration file copied to your application and run the command to apply migrations:

```bash
php artisan migrate
```

## Using

> [`Cashier`](https://github.com/cashier-provider/core) allows you to connect any payment driver compatible with your application.
>
> Depending on the type of payment, Cashier will automatically call the required driver to work with the bank's API.


### Configuration

Before starting, edit the [config/cashier.php](https://github.com/cashier-provider/core/blob/main/config/cashier.php) file:

```php
use App\Models\Payment as Model;
use CashierProvider\Core\Constants\Attributes;
use CashierProvider\Core\Constants\Status;

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

use CashierProvider\Core\Concerns\Casheable;
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
[program:queue-payments-start]
process_name = %(process_num)02d
command = php /var/www/artisan queue:work database --queue=payments_start --tries=100
autostart = true
autorestart = true
numprocs = 4
user = www-data
redirect_stderr = true
stdout_logfile = /var/www/storage/logs/queue-payments-start.log

[program:queue-payments-check]
process_name = %(process_num)02d
command = php /var/www/artisan queue:work database --queue=payments_check --tries=100
autostart = true
autorestart = true
numprocs = 4
user = www-data
redirect_stderr = true
stdout_logfile = /var/www/storage/logs/queue-payments-check.log

[program:queue-payments-refund]
process_name = %(process_num)02d
command = php /var/www/artisan queue:work database --queue=payments_refund --tries=100
autostart = true
autorestart = true
numprocs = 1
user = www-data
redirect_stderr = true
stdout_logfile = /var/www/storage/logs/queue-payments-refund.log
```

### Manual

```php
use App\Models\Payment;
use CashierProvider\Core\Services\Jobs;

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
| [cashier-provider/sber-qr](https://github.com/cashier-provider/sber-qr) | Driver for payment with QR codes via Sber |
| [cashier-provider/tinkoff-qr](https://github.com/cashier-provider/tinkoff-qr) | Driver for payment with QR codes via Tinkoff |

#### Authorization drivers

| Driver | Description |
|:---|:---|
| [cashier-provider/sber-auth](https://github.com/cashier-provider/sber-auth) | Sber API Authorization Driver |
| [cashier-provider/tinkoff-auth](https://github.com/cashier-provider/tinkoff-auth) | Tinkoff API Authorization Driver |

### Development

Create main classes with the following inheritance:

| Class | Extends | Description
|:---|:---|:---|
| `Driver` | `CashierProvider\Core\Services\Driver` | Main driver file. Contains information on exchanging information with the bank via the API. |
| `Exceptions\Manager` | `CashierProvider\Core\Exceptions\Manager` | Error handling manager. Contains information about error codes returned from the bank. |
| `Helpers\Statuses` | `CashierProvider\Core\Services\Statuses` | Types of statuses. Groups the statuses returned by the bank by type. |
| `Resources\Details` | `CashierProvider\Core\Resources\Details` | Details cast. Contains information for working with the bank. For example, in the [`cashier-provider/sber-qr`](https://github.com/cashier-provider/sber-qr) driver, it contains a link to generate a QR code. In your driver, you are free to specify the methods you need. |
| `Requests\Create` | `CashierProvider\Core\Http\Request` | Request to the bank to initiate a payment session. |
| `Requests\Status` | `CashierProvider\Core\Http\Request` | Request to the bank to check the status of the payment. |
| `Requests\Cancel` | `CashierProvider\Core\Http\Request` | Request to the bank to cancel the payment and return the funds to the client if he has already paid for the services. |
| `Responses\Created`, `Responses\Refund`, `Responses\Status` | `CashierProvider\Core\Http\Response` | Classes for processing responses from the bank. |

```php
namespace CashierProvider\BankName\BankTechnology;

use CashierProvider\BankName\BankTechnology\Exceptions\Manager;
use CashierProvider\BankName\BankTechnology\Helpers\Statuses;
use CashierProvider\BankName\BankTechnology\Requests\Cancel;
use CashierProvider\BankName\BankTechnology\Requests\Create;
use CashierProvider\BankName\BankTechnology\Requests\Status;
use CashierProvider\BankName\BankTechnology\Resources\Details;
use CashierProvider\BankName\BankTechnology\Responses\Created;
use CashierProvider\BankName\BankTechnology\Responses\Refund;
use CashierProvider\BankName\BankTechnology\Responses\Status as StatusResponse;
use CashierProvider\Core\Services\Driver as BaseDriver;
use Helldar\Contracts\Cashier\Http\Response;

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

For convenience, we have created a [`Cashier Driver Template`](https://github.com/cashier-provider/driver-template), on the basis of which you can create your own driver. And also
the [`Cashier Authorization Driver Template`](https://github.com/cashier-provider/driver-auth-template).


[badge_downloads]:      https://img.shields.io/packagist/dt/cashier-provider/core.svg?style=flat-square

[badge_license]:        https://img.shields.io/packagist/l/cashier-provider/core.svg?style=flat-square

[badge_stable]:         https://img.shields.io/github/v/release/cashier-provider/core?label=stable&style=flat-square

[badge_unstable]:       https://img.shields.io/badge/unstable-dev--main-orange?style=flat-square

[link_license]:         LICENSE

[link_packagist]:       https://packagist.org/packages/cashier-provider/core
