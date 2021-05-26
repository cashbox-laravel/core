<?php

namespace Helldar\Cashier\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

final class CashierDetail extends Model
{
    protected $casts = [
        'details' => 'json',
    ];

    public function parent(): MorphTo
    {
        return $this->morphTo('item');
    }
}
