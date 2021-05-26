<?php

namespace Helldar\Cashier\Providers;

use Helldar\Cashier\Facade\Config\Payment;
use Helldar\Cashier\Observers\Details as Observer;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ObserverServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $model = $this->model();

        $model::observe(Observer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|string
     */
    protected function model(): string
    {
        return Payment::model();
    }
}
