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

use Helldar\Cashier\Constants\Status;

return [
    /*
     * This value determines the "environment" your application is currently
     * running in.
     */

    'env' => env('APP_ENV', 'production'),

    /*
     * The block is responsible for defining parameters with a payment model.
     */

    'payment' => [
        /*
         * Link to Payment model.
         */

        'model' => App\Models\Payment::class,

        /*
         * Correspondence of Cashier attributes to Payment model.
         */

        'attributes' => [
            'type' => 'type_id',

            'status' => 'status_id',
        ],

        /*
         * Correspondence of statuses to the payment model.
         */

        'statuses' => [
            Status::NEW => 0,

            Status::SUCCESS => 1,

            Status::FAILED => 2,

            Status::REFUND => 3,

            Status::WAIT_REFUND => 4,
        ],

        /*
         * Mapping status types to drivers names.
         */

        'map' => [
            // 'payment_type_1' => 'sber',
            // 'payment_type_2' => 'tinkoff',
        ],
    ],

    'details' => [
        /*
         * Table name for the Cashier Details.
         *
         * Default, cashier_details.
         */

        'table' => 'cashier_details',
    ],

    /*
     * This setting defines which logging channel will be used to write log
     * messages. You are free to specify any of your logging channels listed
     * inside the "logging" configuration file.
     *
     * By default, `null` (disabled).
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

        'timeout' => 30,
    ],

    /*
     * This setting defines the parameters for automatic refunds.
     */

    'auto_refund' => [
        /*
         * This setting determines whether you want to issue an automatic refund
         * of payments.
         *
         * By default, false.
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
        //     'driver' => Helldar\CashierDriver\Sber\QrCode\Driver::class,
        //
        //     'resource' => Helldar\Cashier\Resources\Model::class,
        //
        //     'client_id' => env('CASHIER_SBER_CLIENT_ID'),
        //
        //     'client_secret' => env('CASHIER_SBER_CLIENT_SECRET'),
        // ],
    ],
];
