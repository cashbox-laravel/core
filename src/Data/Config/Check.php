<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config;

use CashierProvider\Core\Casts\DelayCast;
use CashierProvider\Core\Casts\TimeoutCast;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class Check extends Data
{
    #[WithCast(DelayCast::class)]
    public int $delay;

    #[WithCast(TimeoutCast::class)]
    public int $timeout;
}
