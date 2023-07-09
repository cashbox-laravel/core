<?php

namespace Tests\Fixtures\Factories;

use Tests\Fixtures\Models\RequestPayment;
use Tests\TestCase;

class Payment
{
    public static function create(): RequestPayment
    {
        return RequestPayment::create([
            'type_id'   => TestCase::MODEL_TYPE_ID,
            'status_id' => TestCase::MODEL_STATUS_ID,

            'sum'      => TestCase::PAYMENT_SUM,
            'currency' => TestCase::CURRENCY,
        ]);
    }
}
