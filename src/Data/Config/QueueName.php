<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config;

use Spatie\LaravelData\Data;

class QueueName extends Data
{
    public ?string $start;

    public ?string $check;

    public ?string $refund;
}
