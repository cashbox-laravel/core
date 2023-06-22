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

namespace CashierProvider\Core\Observers;

use CashierProvider\Core\Concerns\Events;
use CashierProvider\Core\Facades\Access;
use CashierProvider\Core\Services\Job;
use DragonCode\Support\Facades\Helpers\Arr;
use Illuminate\Database\Eloquent\Model;

class PaymentsObserver extends BaseObserver
{
    use Events;

    public function created(Model $payment): void
    {
        if ($this->allow($payment)) {
            $this->jobs($payment)->start();
        }
    }

    public function updated(Model $payment): void
    {
        if ($this->allow($payment)) {
            $this->event($payment);

            if ($this->wasChanged($payment)) {
                $this->jobs($payment)->check();
            }
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\CashierProvider\Core\Concerns\Casheable  $payment
     */
    public function deleting(Model $payment): void
    {
        $payment->relationLoaded('cashier')
            ? $payment->cashier?->delete()
            : $payment->cashier()?->delete();
    }

    protected function allow(Model $payment): bool
    {
        return Access::allow($payment);
    }

    protected function jobs(Model $payment): Job
    {
        return Job::make($payment);
    }

    protected function wasChanged(Model $payment): bool
    {
        $attributes = Arr::of($payment->getChanges())->except([
            $this->attributeStatus(),
            $this->attributeCreatedAt(),
        ])->keys()->toArray();

        return $payment->wasChanged($attributes);
    }
}
