<?php

namespace Tests\Fixtures\Models;

use CashierProvider\Core\Concerns\Casheable;
use Helldar\LaravelSupport\Eloquent\UuidModel;

/**
 * @property \Illuminate\Support\Carbon $created_at
 * @property float $sum
 * @property int $currency
 * @property int $status_id
 * @property int $type_id
 * @property string $id;
 */
class RequestPayment extends UuidModel
{
    use Casheable;

    protected $table = 'payments';

    protected $fillable = ['type_id', 'status_id', 'sum', 'currency'];

    protected $casts = [
        'type_id'   => 'integer',
        'status_id' => 'integer',

        'sum'      => 'float',
        'currency' => 'integer',
    ];
}
