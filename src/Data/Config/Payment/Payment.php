<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config\Payment;

use CashierProvider\Core\Casts\PaymentModelCast;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class Payment extends Data
{
    #[WithCast(PaymentModelCast::class)]
    public string $model;

    public Attribute $attribute;

    public Status $status;

    public Driver $drivers;
}
