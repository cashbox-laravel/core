<?php

namespace Helldar\Cashier\Helpers;

use Helldar\Cashier\Contracts\Statuses as Contract;

abstract class Statuses implements Contract
{
    public const NEW = [];

    public const REFUNDING = [];

    public const REFUNDED = [];

    public const FAILED = [];

    public const SUCCESS = [];

    public function hasCreated(string $status): bool
    {
        return $this->has($status, static::NEW);
    }

    public function hasFailed(string $status): bool
    {
        return $this->has($status, static::FAILED);
    }

    public function hasRefunding(string $status): bool
    {
        return $this->has($status, static::REFUNDING);
    }

    public function hasRefunded(string $status): bool
    {
        return $this->has($status, static::REFUNDED);
    }

    public function hasSuccess(string $status): bool
    {
        return $this->has($status, static::SUCCESS);
    }

    protected function has(string $status, array $statuses): bool
    {
        return in_array($status, $statuses);
    }
}
