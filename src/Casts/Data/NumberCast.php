<?php

declare(strict_types=1);

namespace CashierProvider\Core\Casts\Data;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class NumberCast implements Cast
{
    public function __construct(
        protected readonly int $min = 0,
        protected readonly int $default = 100
    ) {}

    public function cast(DataProperty $property, mixed $value, array $context): int
    {
        return $value > $this->min ? (int) $value : $this->default;
    }
}
