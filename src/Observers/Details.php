<?php

namespace Helldar\Cashier\Observers;

use Helldar\Cashier\Constants\Status;
use Helldar\Cashier\Facade\Config\Payment;
use Helldar\Cashier\Models\CashierDetail as Model;
use Helldar\Support\Facades\Helpers\Ables\Arrayable;

final class Details
{
    public function created(Model $model)
    {
        if ($this->has($model)) {
            $this->init($model);
        }
    }

    public function updated(Model $model)
    {
        if ($this->has($model)) {
            $this->init($model);
            $this->check($model);
        }
    }

    protected function init(Model $model): void
    {
        // send init request to bank
    }

    protected function check(Model $model): void
    {
        // check payment status
    }

    protected function has(Model $model): bool
    {
        return $this->hasType($model) && $this->hasStatus($model);
    }

    protected function hasType(Model $model): bool
    {
        $field     = $this->typeField();
        $available = $this->types();

        $type = $model->getAttribute($field);

        return in_array($type, $available);
    }

    protected function hasStatus(Model $model): bool
    {
        $field     = $this->statusField();
        $available = $this->statuses();

        $status = $model->getAttribute($field);

        return in_array($status, $available);
    }

    protected function types(): array
    {
        $statuses = Payment::assignDrivers();

        return array_keys($statuses);
    }

    protected function statuses(): array
    {
        $statuses = Payment::statuses();

        return Arrayable::of($statuses)
            ->only([Status::NEW, Status::WAIT_REFUND])
            ->values()
            ->get();
    }

    protected function typeField(): string
    {
        return Payment::attributeType();
    }

    protected function statusField(): string
    {
        return Payment::attributeStatus();
    }
}
