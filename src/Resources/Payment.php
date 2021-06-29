<?php

namespace Helldar\Cashier\Resources;

use Carbon\Carbon;
use Helldar\Cashier\Concerns\Validators;
use Helldar\Cashier\Contracts\Payment as Contract;
use Helldar\Cashier\Facades\Date;
use Helldar\Support\Concerns\Makeable;
use Illuminate\Database\Eloquent\Model;

abstract class Payment implements Contract
{
    use Makeable;
    use Validators;

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getUniqueId(): string
    {
        $unique = $this->uniqueId();

        return md5($unique);
    }

    public function getPaymentId(): string
    {
        return $this->paymentId();
    }

    public function getSum(): int
    {
        $sum = $this->sum();

        return (int) ($sum * 100);
    }

    public function getCurrency(): string
    {
        return $this->currency();
    }

    public function getCreatedAt(): string
    {
        return Date::toString($this->createdAt());
    }

    public function getNow(): string
    {
        $date = Carbon::now();

        return Date::toString($date);
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
}
