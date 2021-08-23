<?php

/*
 * This file is part of the "andrey-helldar/cashier" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/cashier
 */

declare(strict_types=1);

use Helldar\Cashier\Constants\Attributes;
use Helldar\Cashier\Constants\Status;

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

    'env' => env('APP_ENV', 'production'),

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
    | Logger
    |--------------------------------------------------------------------------
    |
    | This setting defines which logging channel will be used by the Stripe
    | library to write log messages. You are free to specify any of your
    | logging channels listed inside the "logging" configuration file.
    |
    */

    'logger' => env('CASHIER_LOGGER'),

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
        | Queue Name
        |--------------------------------------------------------------------------
        |
        | This value specifies the name of the queue into which the task will
        | be placed.
        |
        | By default, `null`.
        |
        */

        'name' => env('CASHIER_QUEUE'),

        /*
        |--------------------------------------------------------------------------
        | Database Transactions
        |--------------------------------------------------------------------------
        |
        | This configuration option determines if your data will only be synced
        | with your search indexes after every open database transaction has
        | been committed, thus preventing any discarded data from syncing.
        |
        */

        'after_commit' => false,
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

        'timeout' => 30,
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
    */

    'drivers' => [
        // 'foo' => [
        //     \Helldar\Cashier\Constants\Driver::DRIVER => \Helldar\CashierDriver\BankName\PaymentType\Driver::class,
        //
        //     \Helldar\Cashier\Constants\Driver::DETAILS => \App\Payments\BankName::class,
        //
        //     \Helldar\Cashier\Constants\Driver::CLIENT_ID => env('CASHIER_BANK_CLIENT_ID'),
        //
        //     \Helldar\Cashier\Constants\Driver::CLIENT_SECRET => env('CASHIER_BANK_CLIENT_SECRET'),
        //
        //     \Helldar\Cashier\Constants\Driver::SSL_VERIFY => true,
        //
        //     \Helldar\Cashier\Constants\Driver::CERTIFICATE_PATH => '/path/to/cert.pem',
        //
        //     \Helldar\Cashier\Constants\Driver::CERTIFICATE_PASSWORD => 'qwerty',
        // ],
    ],
];
