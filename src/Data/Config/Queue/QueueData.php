<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config\Queue;

use CashierProvider\Core\Casts\Data\NumberCast;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class QueueData extends Data
{
    public ?string $connection;

    #[WithCast(NumberCast::class, min: 1, default: 50)]
    public int $tries;

    public QueueNameData $name;
}
