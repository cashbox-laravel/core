<?php

namespace Helldar\Cashier\Observers;

use Helldar\Cashier\Facade\Config\Payment;
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
        $this->jobs->init($model);
    }

    public function updated(Model $model)
    {
        if ($this->has($model)) {
            $this->jobs->init($model);
            $this->jobs->check($model);
        }
    }

    protected function has(Model $model): bool
    {
        $attributes = Payment::attributes();

        return $model->wasChanged($attributes);
    }
}
