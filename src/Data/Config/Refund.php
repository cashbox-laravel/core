<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config;

use CashierProvider\Core\Casts\DelayCast;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class Refund extends Data
{
    public bool $enabled;

    #[WithCast(DelayCast::class)]
    public int $delay;
}
