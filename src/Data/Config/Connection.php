<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config;

use Spatie\LaravelData\Data;

class Connection extends Data
{
    public ?string $name;

    public string $table;
}
