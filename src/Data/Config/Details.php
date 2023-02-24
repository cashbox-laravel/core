<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config;

use Spatie\LaravelData\Data;

class Details extends Data
{
    public ?string $connection;

    public string $table;
}
