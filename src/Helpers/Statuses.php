<?php

namespace Helldar\Cashier\Helpers;

use Helldar\Cashier\Contracts\Statuses as Contract;
use Helldar\Cashier\Facade\Config\Payment;
use Illuminate\Database\Eloquent\Model;

abstract class Statuses implements Contract
{
    public const NEW = [];

    public const REFUNDING = [];

    public const REFUNDED = [];

    public const FAILED = [];

    public const SUCCESS = [];

    public function hasCreated(Model $model): bool
    {
        return $this->has($model, static::NEW);
    }

    public function hasFailed(Model $model): bool
    {
        return $this->has($model, static::FAILED);
    }

    public function hasRefunding(Model $model): bool
    {
        return $this->has($model, static::REFUNDING);
    }

    public function hasRefunded(Model $model): bool
    {
        return $this->has($model, static::REFUNDED);
    }

    public function hasSuccess(Model $model): bool
    {
        return $this->has($model, static::SUCCESS);
    }

    public function inProgress(Model $model): bool
    {
        return ! $this->hasSuccess($model)
            && ! $this->hasFailed($model)
            && ! $this->hasRefunded($model);
    }

    protected function has(Model $model, array $statuses): bool
    {
        $status = $this->status($model);

        return in_array($status, $statuses);
    }

    protected function status(Model $model)
    {
        $attribute = $this->getAttribute();

        return $model->getAttribute($attribute);
    }

    protected function getAttribute(): string
    {
        return Payment::attributeStatus();
    }
}
