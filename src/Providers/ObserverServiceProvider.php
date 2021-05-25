<?php

namespace Helldar\Cashier\Providers;

use Helldar\Cashier\Models\PaymentRequest as Model;
use Helldar\Cashier\Observers\PaymentRequest as Observer;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ObserverServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        Model::observe(Observer::class);
    }
}
