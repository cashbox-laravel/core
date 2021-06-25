<?php

use Helldar\Cashier\Constants\Status;

return [

    'environment' => env('APP_ENV'),

    'payments' => [

        'model' => env('CASHIER_MODEL_PAYMENT', App\Models\Payment::class),

        'attributes' => [
            'type' => 'type_id',

            'status' => 'status_id',

            'sum' => 'sum',
        ],

        'statuses' => [
            Status::NEW => 0,

            Status::SUCCESS => 1,

            Status::FAILED => 2,

            Status::REFUND => 3,

            Status::WAIT_REFUND => 4,
        ],

        'assign_drivers' => [
            // 'payment_type_1' => 'sber',
            // 'payment_type_2' => 'tinkoff',
        ],
    ],

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
     * This setting defines the list of drivers for the implementation of payments.
     */

    'drivers' => [
        // 'sber' => [
        //     'driver' => Helldar\CashierDriver\Sber\QR\Driver::class,
        //
        //     'client_id' => env('CASHIER_SBER_CLIENT_ID'),
        //
        //     'client_secret' => env('CASHIER_SBER_CLIENT_SECRET'),
        // ],
        //
        // 'tinkoff' => [
        //     'driver' => Helldar\CashierDriver\Tinkoff\QR\Driver::class,
        //
        //     'client_id' => env('CASHIER_TINKOFF_CLIENT_ID'),
        //
        //     'client_secret' => env('CASHIER_TINKOFF_CLIENT_SECRET'),
        // ],
    ],
];
