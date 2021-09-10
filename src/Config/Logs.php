<?php

declare(strict_types=1);

namespace Helldar\Cashier\Config;

use Helldar\Contracts\Cashier\Config\Logs as Contract;

class Logs implements Contract
{
    public function isEnabled(): bool
    {
        return config('cashier.logs.enabled', true);
    }

    public function getConnection(): ?string
    {
        return config('cashier.logs.connection');
    }

    public function getTable(): string
    {
        return config('cashier.logs.table', 'cashier_logs');
    }
}
