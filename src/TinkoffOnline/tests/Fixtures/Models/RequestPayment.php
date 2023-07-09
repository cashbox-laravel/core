<?php

/*
 * This file is part of the "cashier-provider/tinkoff-online" project.
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
 * @see https://github.com/cashier-provider/tinkoff-online
 */

namespace Tests\Fixtures\Models;

use CashierProvider\Core\Concerns\Casheable;
use DragonCode\LaravelSupport\Eloquent\UuidModel;

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
