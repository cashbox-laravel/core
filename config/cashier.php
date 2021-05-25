<?php

use Helldar\Cashier\Constants\Statuses;
use Helldar\Cashier\Contracts\Driver;

return [

    /*
     * This setting defines which logging channel will be used to write log
     * messages. You are free to specify any of your logging channels listed
     * inside the "logging" configuration file.
     */

    'logger' => env('CASHIER_LOGGER'),

    /*
     * This parameter determines in which queue workers will be sent for
     * requests to banks.
     */

    'queue' => env('CASHIER_QUEUE'),

    /*
     * This block of settings is responsible for the duration of the requests.
     */

    'check' => [

        /*
         * This setting determines the number of seconds to pause before
         * re-checking the payment status.
         */

        'delay' => 3,

        /*
         * This setting determines the number of seconds after which you need to
         * stop trying to check the status of the payment
         */

        'timeout' => 600,
    ],

    /*
     * This setting defines the parameters for automatic refunds.
     */

    'auto_refund' => [

        /*
         * This setting determines whether you want to issue an automatic refund
         * of payments.
         */

        'enabled' => env('CASHIER_AUTO_REFUND_ENABLED', false),

        /*
         * This setting determines the period after which it is necessary to carry
         * out an automatic refund.
         */

        'delay' => env('CASHIER_AUTO_REFUND_DELAY', 600),
    ],

    /*
     * This setting defines the list of banks for the implementation of payments.
     */

    'banks' => [
        'sber' => [
            'driver' => Driver::class,

            'client' => env('CASHIER_SBER_CLIENT_ID'),

            'secret' => env('CASHIER_SBER_CLIENT_SECRET'),
        ],

        'tinkoff' => [
            'driver' => Driver::class,

            'client' => env('CASHIER_TINKOFF_CLIENT_ID'),

            'secret' => env('CASHIER_TINKOFF_CLIENT_SECRET'),
        ],
    ],

    /*
     * This setting determines the correspondence of the status in your application.
     */

    'statuses' => [
        Statuses::NEW => 0,

        Statuses::SUCCESS => 1,

        Statuses::FAILED => 2,

        Statuses::REFUND => 3,

        Statuses::WAIT_REFUND => 4,
    ],
];
