<?php

namespace Helldar\Cashier\Providers;

use Helldar\Cashier\Facades\Config\Payment;
use Helldar\Cashier\Models\CashierDetail;
use Helldar\Cashier\Observers\DetailsObserver;
use Helldar\Cashier\Observers\PaymentsObserver as PaymentsObserver;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ObserverServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $model = $this->model();

        $model::observe(PaymentsObserver::class);

        CashierDetail::observe(DetailsObserver::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|string
     */
    protected function model(): string
    {
        return Payment::model();
    }
}
