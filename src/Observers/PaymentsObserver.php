<?php

declare(strict_types=1);

namespace Helldar\Cashier\Observers;

use Helldar\Cashier\Facades\Helpers\Access;
use Helldar\Cashier\Services\Jobs;
use Illuminate\Database\Eloquent\Model;

class PaymentsObserver
{
    public function created(Model $model)
    {
        if ($this->allow($model)) {
            $this->jobs($model)->start();
        }
    }

    public function updated(Model $model)
    {
        if ($this->allow($model)) {
            $this->jobs($model)->start();
            $this->jobs($model)->check();
        }
    }

    /**
     * @param  \Helldar\Cashier\Concerns\Casheable|\Illuminate\Database\Eloquent\Model  $model
     */
    public function deleted(Model $model)
    {
        $model->cashier()->delete();
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
