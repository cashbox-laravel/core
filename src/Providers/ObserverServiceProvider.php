<?php

/**
 * This file is part of the "cashier-provider/core" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider
 */

declare(strict_types=1);

namespace CashierProvider\Core\Providers;

use CashierProvider\Core\Facades\Config;
use CashierProvider\Core\Models\CashierDetail;
use CashierProvider\Core\Observers\DetailsObserver;
use CashierProvider\Core\Observers\PaymentsObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ObserverServiceProvider extends BaseServiceProvider
{
    public function boot(): void
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

    protected function model(): Model|string
    {
        return Config::payment()->model;
    }
}
