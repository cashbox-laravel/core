<?php

namespace Helldar\Cashier\Helpers;

use Helldar\Cashier\Contracts\Statuses as Contract;
use Helldar\Support\Concerns\Makeable;
use Illuminate\Database\Eloquent\Model;

abstract class Statuses implements Contract
{
    use Makeable;

    public const NEW = [];

    public const REFUNDING = [];

    public const REFUNDED = [];

    public const FAILED = [];

    public const SUCCESS = [];

    /** @var \Illuminate\Database\Eloquent\Model */
    protected $model;

    public function model(Model $model): Contract
    {
        $this->model = $model;

        return $this;
    }

    public function hasCreated(string $status = null): bool
    {
        $status = $status ?: $this->status();

        return empty($status) || $this->has(static::NEW, $status);
    }

    public function hasFailed(string $status = null): bool
    {
        return $this->has(static::FAILED, $status);
    }

    public function hasRefunding(string $status = null): bool
    {
        return $this->has(static::REFUNDING, $status);
    }

    public function hasRefunded(string $status = null): bool
    {
        return $this->has(static::REFUNDED, $status);
    }

    public function hasSuccess(string $status = null): bool
    {
        return $this->has(static::SUCCESS, $status);
    }

    public function inProgress(string $status = null): bool
    {
        return ! $this->hasSuccess($status)
            && ! $this->hasFailed($status)
            && ! $this->hasRefunded($status);
    }

    protected function has(array $statuses, string $status = null): bool
    {
        $status = $status ?: $this->status();

        return ! empty($status) && in_array($status, $statuses);
    }

    protected function status(): ?string
    {
        if ($this->model->cashier) {
            return $this->model->cashier->details->getStatus();
        }

        return null;
    }
}
