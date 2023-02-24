<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config;

use Spatie\LaravelData\Data;

class Logs extends Data
{
    public bool $enabled;

    public ?string $connection;

    public string $table;
}
