<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config;

use CashierProvider\Core\Casts\Data\NumberCast;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class CheckData extends Data
{
    #[WithCast(NumberCast::class, min: 0, default: 60)]
    public int $delay;

    #[WithCast(NumberCast::class, min: 0, default: 30)]
    public int $timeout;
}
