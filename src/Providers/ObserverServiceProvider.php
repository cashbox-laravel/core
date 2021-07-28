<?php

declare(strict_types = 1);

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
        $this->bootPayment();
        $this->bootPaymentDetails();
    }

    protected function bootPayment(): void
    {
        $model = $this->model();

        $model::observe(PaymentsObserver::class);
    }

    protected function bootPaymentDetails(): void
    {
        CashierDetail::observe(DetailsObserver::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|string
     */
    protected function model(): string
    {
        return Payment::getModel();
    }
}
