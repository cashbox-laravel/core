<?php

/**
 * This file is part of the "cashbox/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashbox-laravel/foundation
 */

declare(strict_types=1);

use Cashbox\Core\Enums\AttributeEnum;
use Cashbox\Core\Enums\StatusEnum;

return [
    /*
    |--------------------------------------------------------------------------
    | Cashbox Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your Cashbox instance is
    | currently running in. This may determine how you prefer to configure
    | various services the application utilizes. Set this in your ".env"
    | file.
    |
    */

    'env' => env('CASHBOX_ENV', env('APP_ENV', 'production')),

    /*
    |--------------------------------------------------------------------------
    | Payment Model
    |--------------------------------------------------------------------------
    |
    | This parameter defines the work with the payment model.
    |
    */

    'payment' => [
        /*
        |--------------------------------------------------------------------------
        | Payment Model
        |--------------------------------------------------------------------------
        |
        | This value defines the work with the payment model.
        |
        */

        'model' => App\Models\Payment::class,

        /*
        |--------------------------------------------------------------------------
        | Payment Model Attributes
        |--------------------------------------------------------------------------
        |
        | Correspondence of Cashbox attributes to Payment model.
        |
        | type of field => column name from payment model
        |
        */

        'attribute' => [
            AttributeEnum::type()      => 'type_id',
            AttributeEnum::status()    => 'status_id',
            AttributeEnum::createdAt() => 'created_at',
        ],

        /*
        |--------------------------------------------------------------------------
        | Payment Statuses
        |--------------------------------------------------------------------------
        |
        | Correspondence of statuses to the payment model.
        |
        | internal status => your status name or ID or enum class.
        |
        */

        'status' => [
            StatusEnum::new()        => 'new',
            StatusEnum::success()    => 'success',
            StatusEnum::waitRefund() => 'wait_refund',
            StatusEnum::refund()     => 'refund',
            StatusEnum::failed()     => 'failed',
        ],

        /*
        |--------------------------------------------------------------------------
        | Drivers Connections
        |--------------------------------------------------------------------------
        |
        | Here you may configure the connection information for each payment type
        | that is used by your application.
        |
        */

        'drivers' => [
            // 'app_payment_type_1' => 'driver_name_foo',
            // 'app_payment_type_2' => 'driver_name_bar',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cashbox Details
    |--------------------------------------------------------------------------
    |
    | This parameter contains settings for the Cashbox table.
    |
    */

    'details' => [
        /*
        |--------------------------------------------------------------------------
        | Connection Name
        |--------------------------------------------------------------------------
        |
        | This value defines the name of the connection for accessing the
        | database with the Cashbox table.
        |
        */

        'connection' => env('DB_CONNECTION'),

        /*
        |--------------------------------------------------------------------------
        | Cashbox Details table settings
        |--------------------------------------------------------------------------
        |
        | Table name for the Cashbox Details.
        |
        */

        'table' => 'cashbox_details',
    ],

    /*
    |--------------------------------------------------------------------------
    | Logs
    |--------------------------------------------------------------------------
    |
    | This setting specifies the channel name for logging requests and
    | responses from the bank.
    |
    | Specify `null` to disable logging.
    |
    */

    'logs' => [
        'info'  => env('CASHBOX_LOGS_CHANNEL_INFO'),
        'error' => env('CASHBOX_LOGS_CHANNEL_ERROR'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue Connections
    |--------------------------------------------------------------------------
    |
    | This parameter determines in which queue workers will be sent for
    | requests to banks.
    |
    */

    'queue' => [
        /*
        |--------------------------------------------------------------------------
        | Queue Connection Name
        |--------------------------------------------------------------------------
        |
        | This value indicates which queue service the jobs will fall into.
        |
        | Here you may define a default connection.
        |
        | By default, `null`.
        |
        */

        'connection' => env('QUEUE_CONNECTION'),

        /*
        |--------------------------------------------------------------------------
        | Max Attempts
        |--------------------------------------------------------------------------
        |
        | This value determines the number of attempts to execute the job
        | before logging it failed.
        |
        | By default, 50.
        |
        */

        'tries' => 50,

        /*
        |--------------------------------------------------------------------------
        | Max Attempts
        |--------------------------------------------------------------------------
        |
        | This value determines the maximum number of unhandled exceptions
        | to allow before failing.
        |
        | Minimum: 3
        | Maximum: 10
        |
        */

        'exceptions' => 3,

        /*
        |--------------------------------------------------------------------------
        | Queue Names
        |--------------------------------------------------------------------------
        |
        | This value specifies the names of the queue into which the task will
        | be placed.
        |
        */

        'name' => [
            /*
            |--------------------------------------------------------------------------
            | Initialize Queue Name
            |--------------------------------------------------------------------------
            |
            | This value defines the queue name for payment initiation tasks.
            |
            | By default, `null`.
            |
            */

            'start' => env('CASHBOX_QUEUE'),

            /*
            |--------------------------------------------------------------------------
            | Verify Queue Name
            |--------------------------------------------------------------------------
            |
            | This value defines the queue name for payment checking tasks.
            |
            | By default, `null`.
            |
            */

            'verify' => env('CASHBOX_QUEUE'),

            /*
            |--------------------------------------------------------------------------
            | Refund Queue Name
            |--------------------------------------------------------------------------
            |
            | This value defines the queue name for payment refund tasks.
            |
            | By default, `null`.
            |
            */

            'refund' => env('CASHBOX_QUEUE'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Verify Requests
    |--------------------------------------------------------------------------
    |
    | This parameter of settings is responsible for the duration of the requests.
    |
    */

    'verify' => [
        /*
        |--------------------------------------------------------------------------
        | Delay
        |--------------------------------------------------------------------------
        |
        | This setting determines the number of seconds to pause before
        | re-verifying the payment status.
        |
        */

        'delay' => 3,

        /*
        |--------------------------------------------------------------------------
        | Timeout
        |--------------------------------------------------------------------------
        |
        | This setting determines the number of seconds after which you need to
        | stop trying to verify the status of the payment.
        |
        */

        'timeout' => 600,
    ],

    /*
    |--------------------------------------------------------------------------
    | Auto Refund
    |--------------------------------------------------------------------------
    |
    | This parameter defines the parameters for automatic refunds.
    |
    */

    'auto_refund' => [
        /*
        |--------------------------------------------------------------------------
        | Allow Refund
        |--------------------------------------------------------------------------
        |
        | This setting determines whether you want to issue an automatic refund
        | of payments.
        |
        | By default, false.
        |
        */

        'enabled' => (bool) env('CASHBOX_AUTO_REFUND_ENABLED', false),

        /*
        |--------------------------------------------------------------------------
        | Refund Delay
        |--------------------------------------------------------------------------
        |
        | This setting determines the period after which it is necessary to carry
        | out an automatic refund.
        |
        | The value is in seconds.
        |
        */

        'delay' => env('CASHBOX_AUTO_REFUND_DELAY', 600),
    ],

    /*
    |--------------------------------------------------------------------------
    | Drivers
    |--------------------------------------------------------------------------
    |
    | This setting defines the list of drivers for the implementation of
    | payments.
    |
    | You can specify your own names for the driver queue.
    |
    | This is necessary in order to divide the number of request workers
    | to banks that have a limit on the number of requests per minute.
    |
    */

    'drivers' => [
        // 'driver_name_foo' => [
        //    'driver' => \Cashbox\CoreDriver\BankName\PaymentType\Driver::class,
        //
        //    'resource' => \App\Payments\BankName::class,
        // ],
        //
        // 'driver_name_bar' => [
        //    'driver' => \Cashbox\CoreDriver\BankName\PaymentType\Driver::class,
        //
        //    'resource' => \App\Payments\BankName::class,
        //
        //    'credentials' => [
        //        'client_id'     => env('CASHBOX_BANK_CLIENT_ID'),
        //        'client_secret' => env('CASHBOX_BANK_CLIENT_SECRET'),
        //    ],
        //
        //    'queue' => [
        //        'start'  => env('CASHBOX_QUEUE'),
        //        'verify' => env('CASHBOX_QUEUE'),
        //        'refund' => env('CASHBOX_QUEUE'),
        //    ],
        // ],
    ],
];
