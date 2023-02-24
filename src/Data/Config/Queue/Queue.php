<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config\Queue;

use CashierProvider\Core\Casts\TriesCast;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class Queue extends Data
{
    public ?string $connection;

    #[WithCast(TriesCast::class)]
    public int $tries;

    public Name $name;
}
