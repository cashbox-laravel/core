<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config\Payment;

use Spatie\LaravelData\Data;

class Payment extends Data
{
    public string $model;

    public Attribute $attribute;

    public Status $status;

    public Driver $drivers;
}
