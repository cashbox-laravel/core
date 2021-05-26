<?php

namespace Helldar\Cashier\Observers;

use Helldar\Cashier\Models\CashierDetail as Model;
use Helldar\Cashier\Services\Jobs;

final class Details
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
        $this->jobs->init($model);
        $this->jobs->check($model);
    }
}
