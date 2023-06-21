<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config;

use CashierProvider\Core\Data\Config\Drivers\CredentialsData;
use CashierProvider\Core\Data\Config\Queue\QueueNameData;
use CashierProvider\Core\Services\Driver as Service;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class DriverData extends Data
{
    public Service|string $driver;

    public string $details;

    public ?CredentialsData $credentials;

    public ?QueueNameData $queue;
}
