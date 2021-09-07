<?php

declare(strict_types=1);

namespace Helldar\Cashier\Config\Queues;

use Helldar\Contracts\Cashier\Config\Queues\Unique as Contract;
use Helldar\SimpleDataTransferObject\DataTransferObject;

class Unique extends DataTransferObject implements Contract
{
    protected $driver;

    protected $seconds;

    public function getDriver(): string
    {
        return $this->driver;
    }

    public function getSeconds(): int
    {
        $value = abs($this->seconds);

        return $value > 0 ? $value : 3600;
    }
}
