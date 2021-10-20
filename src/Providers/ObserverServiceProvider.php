<?php

/*
 * This file is part of the "andrey-helldar/cashier" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/cashier
 */

declare(strict_types=1);

namespace CashierProvider\Manager\Providers;

use CashierProvider\Manager\Facades\Config\Payment;
use CashierProvider\Manager\Models\CashierDetail;
use CashierProvider\Manager\Observers\DetailsObserver;
use CashierProvider\Manager\Observers\PaymentsObserver as PaymentsObserver;
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
