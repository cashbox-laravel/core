<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config\Payment;

use CashierProvider\Core\Casts\PaymentModelCast;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class PaymentData extends Data
{
    #[WithCast(PaymentModelCast::class)]
    public string $model;

    public AttributeData $attribute;

    public StatusData $status;

    /** @var \Illuminate\Support\Collection<string,string> */
    public Collection $drivers;
}
