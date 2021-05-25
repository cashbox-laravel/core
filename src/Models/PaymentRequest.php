<?php

namespace Helldar\Cashier\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

final class PaymentRequest extends Model
{
    public $timestamps = false;

    protected $casts = [
        'payment_id' => 'integer',

        'request'  => 'json',
        'response' => 'json',
    ];

    public function parent(): MorphTo
    {
        return $this->morphTo();
    }
}
