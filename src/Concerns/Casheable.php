<?php

namespace Helldar\Cashier\Concerns;

use Helldar\Cashier\Models\CashierDetail;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/** @mixin \Illuminate\Database\Eloquent\Model */
trait Casheable
{
    /**
     * Relation to model with payment status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function cashier(): MorphOne
    {
        return $this->morphOne(CashierDetail::class, 'item');
    }
}
