<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Resources;

use Carbon\Carbon;
use Helldar\Cashier\Concerns\Validators;
use Helldar\Cashier\DTO\Authorization;
use Helldar\Cashier\Facades\Helpers\Date;
use Helldar\Cashier\Facades\Helpers\Unique;
use Helldar\Contracts\Cashier\Auth\Authorization as ClientContract;
use Helldar\Contracts\Cashier\DTO\Config;
use Helldar\Contracts\Cashier\Resources\Request as RequestContract;
use Helldar\Support\Concerns\Makeable;
use Illuminate\Database\Eloquent\Model;

abstract class Request implements RequestContract
{
    use Makeable;
    use Validators;

    /** @var \Helldar\Contracts\Cashier\DTO\Config */
    protected $config;

    /** @var \Illuminate\Database\Eloquent\Model */
    protected $model;

    /** @var string */
    protected $unique_id;

    public function __construct(Model $model, Config $config)
    {
        $this->model  = $model;
        $this->config = $config;
    }

    public function getAuthentication(): ClientContract
    {
        return Authorization::make()
            ->setClientId($this->config->getClientId())
            ->setClientSecret($this->config->getClientSecret());
    }

    public function getUniqueId(bool $every = false): string
    {
        if (! empty($this->unique_id) && ! $every) {
            return $this->unique_id;
        }

        return $this->unique_id = Unique::uid();
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
