<?php

namespace Helldar\Cashier\Resources;

use Carbon\Carbon;
use Helldar\Cashier\Facades\Date;

abstract class Request extends BaseResource
{
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
        return $this->formatDate($this->createdAt());
    }

    public function getNow(): string
    {
        return $this->formatDate($this->now());
    }

    protected function uniqueId(): string
    {
        return implode(':', [
            $this->getPaymentId(),
            $this->getSum(),
            $this->getCurrency(),
        ]);
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

    protected function now(): Carbon
    {
        return Carbon::now();
    }

    protected function formatDate(Carbon $date): string
    {
        return Date::toString($date);
    }
}
