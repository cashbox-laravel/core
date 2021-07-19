<?php

namespace Helldar\Cashier\Concerns;

use Helldar\Cashier\Contracts\Driver as Contract;
use Helldar\Cashier\Contracts\Statuses;
use Helldar\Cashier\Exceptions\IncorrectDriverException;
use Helldar\Cashier\Exceptions\IncorrectStatusesException;
use Helldar\Cashier\Exceptions\UnknownMethodException;
use Helldar\Cashier\Exceptions\UnknownResponseException;
use Helldar\Cashier\Resources\Request;
use Helldar\Cashier\Resources\Response;
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

    protected function validateResource(string $request): void
    {
        $this->validate($request, Request::class, UnknownMethodException::class);
    }

    protected function validateResponse(?string $response): void
    {
        $this->validate($response ?: '', Response::class, UnknownResponseException::class);
    }

    protected function validateMethod(string $haystack, string $method): void
    {
        throw new UnknownMethodException($haystack, $method);
    }

    protected function validate(string $haystack, string $needle, string $exception): void
    {
        if (! Instance::of($haystack, $needle)) {
            throw new $exception($haystack);
        }
    }
}
