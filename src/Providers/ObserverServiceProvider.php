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

use Illuminate\Database\Eloquent\Model;

class ObserverServiceProvider extends BaseProvider
{
    public function boot(): void
    {
        if ($this->disabled()) {
            return;
        }

        $this->bootPayment();
        $this->bootPaymentDetails();
    }

    protected function bootPayment(): void
    {
        if ($model = $this->resolveModel()) {
            $model::observe(PaymentsObserver::class);
        }
    }

    protected function bootPaymentDetails(): void
    {
        CashierDetail::observe(DetailsObserver::class);
    }

    protected function resolveModel(): Model|string|null
    {
        $model = $this->model();

        return class_exists($model) ? $model : null;
    }

    protected function model(): string
    {
        return Config::payment()->model;
    }
}
