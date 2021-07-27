<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Config;

use Helldar\Contracts\Cashier\Config\Driver as DriverContract;
use Helldar\Contracts\Cashier\Config\Main as MainContract;

class Main extends Base implements MainContract
{
    public function isProduction(): bool
    {
        return app('cashier.env') === 'production';
    }

    public function getLogger(): ?string
    {
        return config('cashier.logger');
    }

    public function getQueue(): ?string
    {
        return config('cashier.queue');
    }

    public function getCheckDelay(): int
    {
        $value = config('cashier.check.delay', 3);

        return $this->moduleValue($value);
    }

    public function getCheckTimeout(): int
    {
        $value = config('cashier.check.timeout', 30);

        return $this->moduleValue($value);
    }

    public function getAutoRefundEnabled(): bool
    {
        return config('cashier.auto_refund.enabled');
    }

    public function getAutoRefundDelay(): int
    {
        $value = config('cashier.auto_refund.delay', 600);

        return $this->moduleValue($value);
    }

    public function getDriver(string $name): DriverContract
    {
        $driver = config('cashier.drivers.' . $name);

        return Driver::make($driver);
    }
}
