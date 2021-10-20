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

namespace CashierProvider\Manager\Observers;

use CashierProvider\Manager\Concerns\Events;
use CashierProvider\Manager\Facades\Helpers\Access;
use CashierProvider\Manager\Services\Jobs;
use Helldar\Support\Facades\Helpers\Ables\Arrayable;
use Illuminate\Database\Eloquent\Model;

class PaymentsObserver extends BaseObserver
{
    use Events;

    public function created(Model $payment)
    {
        if ($this->allow($payment)) {
            $this->jobs($payment)->start();
        }
    }

    public function updated(Model $payment)
    {
        if ($this->allow($payment)) {
            $this->event($payment);

            if ($this->wasChanged($payment)) {
                $this->jobs($payment)->check();
            }
        }
    }

    /**
     * @param  \CashierProvider\Manager\Concerns\Casheable|\Illuminate\Database\Eloquent\Model  $payment
     */
    public function deleting(Model $payment)
    {
        $payment->cashier()->delete();
    }

    protected function allow(Model $payment): bool
    {
        return Access::allow($payment);
    }

    protected function jobs(Model $payment): Jobs
    {
        return Jobs::make($payment);
    }

    protected function wasChanged(Model $payment): bool
    {
        $attributes = Arrayable::of($payment->getChanges())
            ->except([
                $this->attributeStatus(),
                $this->attributeCreatedAt(),
            ])->keys()->get();

        return $payment->wasChanged($attributes);
    }
}
