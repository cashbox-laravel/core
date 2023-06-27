<?php

/**
 * This file is part of the "cashier-provider/core" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider
 */

declare(strict_types=1);

use App\Payments\BankName;
use CashierProvider\Core\Constants\Attributes;
use CashierProvider\Core\Constants\Queue;
use CashierProvider\Core\Constants\Status;

return [
    /*
    |--------------------------------------------------------------------------
    | Cashier Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your cashier instance is
    | currently running in. This may determine how you prefer to configure
    | various services the application utilizes. Set this in your ".env"
    | file.
    |
    */

    'env' => env('CASHIER_ENV', env('APP_ENV', 'production')),

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
        | Correspondence of Cashier attributes to Payment model.
        |
        */

        'attributes' => [
            Attributes::TYPE => 'type_id',

            Attributes::STATUS => 'status_id',

            Attributes::CREATED_AT => 'created_at',
        ],

        /*
        |--------------------------------------------------------------------------
        | Payment Statuses
        |--------------------------------------------------------------------------
        |
        | Correspondence of statuses to the payment model.
        |
        */

        'statuses' => [
            Status::NEW => 0,

            Status::SUCCESS => 1,

            Status::FAILED => 2,

            Status::REFUND => 3,

            Status::WAIT_REFUND => 4,
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

        'map' => [
            // 'payment_type_1' => 'foo',
            // 'payment_type_2' => 'bar',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cashier Details
    |--------------------------------------------------------------------------
    |
    | This parameter contains settings for the cashier table.
    |
    */

    'details' => [
        /*
        |--------------------------------------------------------------------------
        | Cashier Details table settings
        |--------------------------------------------------------------------------
        |
        | Table name for the Cashier Details.
        |
        */

        'table' => 'cashier_details',
    ],

    /*
    |--------------------------------------------------------------------------
    | Logs
    |--------------------------------------------------------------------------
    |
    | This setting defines the data for connecting to the logging table.
    |
    */

    'logs' => [
        /*
        |--------------------------------------------------------------------------
        | Enabling Logging
        |--------------------------------------------------------------------------
        |
        | This parameter indicates the need to save logs of requests and
        | responses from the bank.
        |
        | By default, true.
        |
        */

        'enabled' => env('CASHIER_REQUESTS_LOGS_ENABLED', true),

        /*
        |--------------------------------------------------------------------------
        | Connection Name
        |--------------------------------------------------------------------------
        |
        | This value defines the name of the connection for accessing the
        | database with the logging table.
        |
        */

        'connection' => null,

        /*
        |--------------------------------------------------------------------------
        | Cashier Details Logs Table
        |--------------------------------------------------------------------------
        |
        | This value contains the name of the table for storing query logs.
        |
        */

        'table' => 'cashier_logs',
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
        | Queue Names
        |--------------------------------------------------------------------------
        |
        | This value specifies the names of the queue into which the task will
        | be placed.
        |
        */

        'names' => [
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

            Queue::START => env('CASHIER_QUEUE'),

            /*
            |--------------------------------------------------------------------------
            | Check Queue Name
            |--------------------------------------------------------------------------
            |
            | This value defines the queue name for payment checking tasks.
            |
            | By default, `null`.
            |
            */

            Queue::CHECK => env('CASHIER_QUEUE'),

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

            Queue::REFUND => env('CASHIER_QUEUE'),
        ],

        /*
        |--------------------------------------------------------------------------
        | Database Transactions
        |--------------------------------------------------------------------------
        |
        | This configuration option determines if your data will only be synced
        | with your search indexes after every open database transaction has
        | been committed, thus preventing any discarded data from syncing.
        |
        | By default, true.
        |
        */

        'after_commit' => true,

        /*
        |--------------------------------------------------------------------------
        | Max Attempts
        |--------------------------------------------------------------------------
        |
        | This value determines the number of attempts to execute the job
        | before logging it failed.
        |
        | By default, 100.
        |
        */

        'tries' => 100,

        /*
        |--------------------------------------------------------------------------
        | Unique Lock
        |--------------------------------------------------------------------------
        |
        | This value contains parameters for implementing uniqueness of queues.
        |
        */

        'unique' => [
            /*
            |--------------------------------------------------------------------------
            | Lock's Timeout
            |--------------------------------------------------------------------------
            |
            | The number of seconds after which the job's unique lock will be released.
            |
            | By default, 60.
            |
            */

            'seconds' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Check Requests
    |--------------------------------------------------------------------------
    |
    | This parameter of settings is responsible for the duration of the requests.
    |
    */

    'check' => [
        /*
        |--------------------------------------------------------------------------
        | Delay
        |--------------------------------------------------------------------------
        |
        | This setting determines the number of seconds to pause before
        | re-checking the payment status.
        |
        */

        'delay' => 3,

        /*
        |--------------------------------------------------------------------------
        | Timeout
        |--------------------------------------------------------------------------
        |
        | This setting determines the number of seconds after which you need to
        | stop trying to check the status of the payment.
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

        'enabled' => env('CASHIER_AUTO_REFUND_ENABLED', false),

        /*
        |--------------------------------------------------------------------------
        | Refund Delay
        |--------------------------------------------------------------------------
        |
        | This setting determines the period after which it is necessary to carry
        | out an automatic refund.
        |
        */

        'delay' => env('CASHIER_AUTO_REFUND_DELAY', 600),
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
        // 'foo' => [
        //     \CashierProvider\Core\Constants\Driver::DRIVER => \CashierProvider\CoreDriver\BankName\PaymentType\Driver::class,
        //
        //     \CashierProvider\Core\Constants\Driver::DETAILS => \App\Payments\BankName::class,
        //
        //     \CashierProvider\Core\Constants\Driver::CLIENT_ID => env('CASHIER_BANK_CLIENT_ID'),
        //
        //     \CashierProvider\Core\Constants\Driver::CLIENT_SECRET => env('CASHIER_BANK_CLIENT_SECRET'),
        // ],
        //
        //'bar' => [
        //    \CashierProvider\Core\Constants\Driver::DRIVER => \CashierProvider\CoreDriver\BankName\PaymentType\Driver::class,
        //
        //    \CashierProvider\Core\Constants\Driver::DETAILS => BankName::class,
        //
        //    \CashierProvider\Core\Constants\Driver::CLIENT_ID => env('CASHIER_BANK_CLIENT_ID'),
        //
        //    \CashierProvider\Core\Constants\Driver::CLIENT_SECRET => env('CASHIER_BANK_CLIENT_SECRET'),
        //
        //    \CashierProvider\Core\Constants\Driver::QUEUE => [
        //        Queue::START  => env('CASHIER_QUEUE'),
        //        Queue::CHECK  => env('CASHIER_QUEUE'),
        //        Queue::REFUND => env('CASHIER_QUEUE'),
        //    ],
        //],
    ],
];
