<?php

declare(strict_types=1);

namespace CashierProvider\Core\Casts\Data;

use CashierProvider\Core\Concerns\Validators;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class PaymentModelCast implements Cast
{
    use Validators;

    public function cast(DataProperty $property, mixed $value, array $context): string
    {
        return $this->validateModel($value);
    }
}
