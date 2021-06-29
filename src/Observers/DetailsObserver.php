<?php

namespace Helldar\Cashier\Observers;

use Helldar\Cashier\Facades\Access;
use Helldar\Cashier\Facades\Config\Payment;
use Helldar\Cashier\Models\CashierDetail as Model;
use Helldar\Cashier\Services\Jobs;

final class DetailsObserver
{
    protected $jobs;

    public function __construct(Jobs $jobs)
    {
        $this->jobs = $jobs;
    }

    public function created(Model $model)
    {
        if ($this->allow($model)) {
            $this->jobs->init($model);
        }
    }

    public function updated(Model $model)
    {
        if ($this->allow($model) && $this->wasChanged($model)) {
            $this->jobs->init($model);
            $this->jobs->check($model);
        }
    }

    protected function wasChanged(Model $model): bool
    {
        $attributes = Payment::attributes();

        return $model->wasChanged($attributes);
    }

    protected function allow(Model $model): bool
    {
        return Access::allow($model);
    }
}
