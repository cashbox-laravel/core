<?php

declare(strict_types=1);

namespace Helldar\Cashier\Concerns;

use Helldar\Cashier\Models\CashierDetail;
use Illuminate\Database\Eloquent\Model;

trait Relations
{
    protected function resolvePayment(CashierDetail $detail): void
    {
        if (empty($detail->parent)) {
            $parent = $detail->parent()->first();

            $detail->setRelation('parent', $parent);
        }
    }

    /**
     * @param  \Helldar\Cashier\Concerns\Casheable|\Illuminate\Database\Eloquent\Model  $payment
     */
    protected function resolveCashier(Model $payment): void
    {
        if (empty($payment->cashier)) {
            $cashier = $payment->cashier()->first();

            $payment->setRelation('cashier', $cashier);
        }
    }
}
