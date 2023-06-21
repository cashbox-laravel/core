<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config\Payment;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class AttributeData extends Data
{
    public string $type;

    public string $status;

    public string $createdAt;
}
