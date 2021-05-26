<?php

namespace Helldar\Cashier\Concerns;

use Helldar\Cashier\Models\CashierDetail;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/** @mixin \Illuminate\Database\Eloquent\Model */
trait Casheable
{
    public function details(): MorphOne
    {
        return $this->morphOne(CashierDetail::class, 'item');
    }
}
