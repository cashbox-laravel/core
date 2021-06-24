<?php

namespace Helldar\Cashier\Concerns;

use Helldar\Cashier\Contracts\Driver as Contract;
use Helldar\Cashier\Contracts\Statuses;
use Helldar\Cashier\Exceptions\IncorrectDriverException;
use Helldar\Cashier\Exceptions\IncorrectStatusesException;
use Helldar\Support\Facades\Helpers\Instance;

trait Validators
{
    protected function validateDriver(string $driver): void
    {
        $this->validate($driver, Contract::class, IncorrectDriverException::class);
    }

    protected function validateStatuses(string $statuses): void
    {
        $this->validate($statuses, Statuses::class, IncorrectStatusesException::class);
    }

    protected function validate(string $haystack, string $needle, string $exception): void
    {
        if (! Instance::of($haystack, $needle)) {
            throw new $exception($haystack);
        }
    }
}
