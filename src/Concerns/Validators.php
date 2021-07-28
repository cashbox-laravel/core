<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Concerns;

use Helldar\Cashier\Exceptions\Runtime\Implement\IncorrectDriverException;
use Helldar\Cashier\Exceptions\Runtime\Implement\IncorrectPaymentModelException;
use Helldar\Cashier\Exceptions\Runtime\Implement\IncorrectStatusesException;
use Helldar\Cashier\Exceptions\Runtime\Implement\UnknownResponseException;
use Helldar\Cashier\Exceptions\Runtime\UnknownMethodException;
use Helldar\Cashier\Facades\Config\Payment;
use Helldar\Cashier\Resources\Request;
use Helldar\Cashier\Resources\Response;
use Helldar\Contracts\Cashier\Driver as Contract;
use Helldar\Contracts\Cashier\Helpers\Status;
use Helldar\Support\Facades\Helpers\Instance;
use Illuminate\Database\Eloquent\Model;

trait Validators
{
    protected function validateModel($model): Model
    {
        $needle = Payment::getModel();

        return $this->validate($model, $needle, IncorrectPaymentModelException::class);
    }

    protected function validateDriver(string $driver): string
    {
        return $this->validate($driver, Contract::class, IncorrectDriverException::class);
    }

    protected function validateStatuses(string $statuses): string
    {
        return $this->validate($statuses, Status::class, IncorrectStatusesException::class);
    }

    protected function validateResource(string $request): string
    {
        return $this->validate($request, Request::class, UnknownMethodException::class);
    }

    protected function validateResponse(?string $response): ?string
    {
        return $this->validate($response, Response::class, UnknownResponseException::class);
    }

    protected function validateMethod(string $haystack, string $method): void
    {
        throw new UnknownMethodException($haystack, $method);
    }

    protected function validate($haystack, string $needle, string $exception)
    {
        if (! Instance::of($haystack, $needle)) {
            throw new $exception($haystack);
        }

        return $haystack;
    }
}
