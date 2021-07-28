<?php

declare(strict_types=1);

namespace Helldar\Cashier\Helpers;

use Helldar\Contracts\Cashier\Helpers\Statuses as Contract;
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

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function hasUnknown(string $status = null): bool
    {
        $status = $status ?: $this->status();

        return ! $this->has(array_merge([
            static::NEW,
            static::REFUNDING,
            static::REFUNDED,
            static::FAILED,
            static::SUCCESS,
        ]), $status);
    }

    public function hasCreated(string $status = null): bool
    {
        $status = $status ?: $this->status();

        return $this->has(static::NEW, $status);
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
        return $this->hasCreated($status) || $this->hasRefunding($status);
    }

    protected function has(array $statuses, string $status = null): bool
    {
        $status = $status ?: $this->status();

        return ! empty($status) && in_array($status, $statuses, true);
    }

    protected function status(): ?string
    {
        if ($this->model->cashier && $this->model->cashier->details) {
            return $this->model->cashier->details->getStatus();
        }

        return null;
    }
}
