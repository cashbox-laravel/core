<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config\Queue;

use Spatie\LaravelData\Data;

class Name extends Data
{
    public ?string $start;

    public ?string $check;

    public ?string $refund;
}
