<?php

declare(strict_types=1);

namespace Helldar\Cashier\Resources;

use Helldar\Cashier\Facades\Helpers\Date;
use Helldar\Cashier\Facades\Helpers\Unique;
use Helldar\Contracts\Cashier\Resources\Model as Contract;
use Helldar\Support\Concerns\Makeable;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Carbon;

abstract class Model implements Contract
{
    use Makeable;

    protected $model;

    public function __construct(EloquentModel $model)
    {
        $this->model = $model;
    }

    public function getClientId(): string
    {
        return $this->clientId();
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret();
    }

    public function getUniqueId(bool $every = false): string
    {
        return Unique::id($every);
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
        $date = $this->createdAt();

        return Date::toString($date);
    }

    abstract protected function clientId(): string;

    abstract protected function clientSecret(): string;

    abstract protected function paymentId(): string;

    abstract protected function sum(): float;

    abstract protected function currency(): string;

    abstract protected function createdAt(): Carbon;
}
