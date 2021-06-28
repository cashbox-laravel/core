<?php

namespace Helldar\Cashier\Requests;

use Carbon\Carbon;
use Helldar\Cashier\Concerns\Validators;
use Helldar\Cashier\Facade\Date;
use Helldar\Support\Concerns\Makeable;
use Illuminate\Database\Eloquent\Model;

abstract class Payment
{
    use Makeable;
    use Validators;

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    protected function uniqueId(): string
    {
        $this->validateMethod(static::class, __FUNCTION__);
    }

    protected function paymentId(): string
    {
        $this->validateMethod(static::class, __FUNCTION__);
    }

    protected function sum(): float
    {
        $this->validateMethod(static::class, __FUNCTION__);
    }

    protected function currency(): int
    {
        $this->validateMethod(static::class, __FUNCTION__);
    }

    protected function createdAt(): Carbon
    {
        $this->validateMethod(static::class, __FUNCTION__);
    }

    protected function getUniqueId(): string
    {
        $unique = $this->uniqueId();

        return md5($unique);
    }

    protected function getPaymentId(): string
    {
        return $this->paymentId();
    }

    protected function getSum(): int
    {
        $sum = $this->sum();

        return (int) ($sum * 100);
    }

    protected function getCurrency(): string
    {
        return $this->currency();
    }

    protected function getCreatedAt(): string
    {
        return Date::toString($this->createdAt());
    }

    protected function getNow(): string
    {
        $date = Carbon::now();

        return Date::toString($date);
    }
}
