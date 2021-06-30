<?php

namespace Helldar\Cashier\Observers;

use Helldar\Cashier\Facades\Access;
use Helldar\Cashier\Facades\Config\Payment;
use Helldar\Cashier\Services\Jobs;
use Illuminate\Database\Eloquent\Model;

class DetailsObserver
{
    public function created(Model $model)
    {
        if ($this->allow($model)) {
            $this->jobs($model)->start();
        }
    }

    public function updated(Model $model)
    {
        if ($this->allow($model) && $this->wasChanged($model)) {
            $this->jobs($model)->start();
            $this->jobs($model)->check();
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

    protected function jobs(Model $model): Jobs
    {
        return Jobs::make($model);
    }
}
