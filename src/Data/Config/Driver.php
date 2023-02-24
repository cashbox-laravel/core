<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class Driver extends Data
{
    /** @var \CashierProvider\Core\Services\Driver|string */
    public string $driver;

    public string $details;

    public ?Credentials $credentials;

    public ?QueueName $queue;
}
