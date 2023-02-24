<?php

declare(strict_types=1);

namespace CashierProvider\Core\Casts;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class TriesCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): int
    {
        return $value > 1 ? (int) $value : 100;
    }
}
