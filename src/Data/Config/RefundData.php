<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config;

use CashierProvider\Core\Casts\Data\NumberCast;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class RefundData extends Data
{
    public bool $enabled;

    #[WithCast(NumberCast::class, min: 0, default: 600)]
    public int $delay;
}
