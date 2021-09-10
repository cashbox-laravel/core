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

namespace Helldar\Cashier\Models;

use Helldar\Cashier\Facades\Config\Details;
use Helldar\Cashier\Facades\Config\Payment;
use Helldar\LaravelSupport\Traits\InitModelHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property \Helldar\Cashier\Concerns\Casheable|\Illuminate\Database\Eloquent\Model $payment
 * @property array $extra
 * @property array $request
 * @property array $response
 * @property float $sum
 * @property int $payment_id
 * @property int $status_code
 * @property string $currency
 * @property string $external_id
 * @property string $method
 * @property string $url
 */
class CashierDetailsLog extends Model
{
    use InitModelHelper;

    protected $fillable = ['payment_id', 'external_id', 'sum', 'currency', 'method', 'url', 'status_code', 'request', 'response'];

    protected $casts = [
        'payment_id' => 'integer',

        'status_code' => 'integer',

        'external_id' => 'string',

        'sum' => 'integer',

        'request'  => 'json',
        'response' => 'json',
        'extra'    => 'json',
    ];

    public function __construct(array $attributes = [])
    {
        $this->setTable(Details::getLogsTable());

        parent::__construct($attributes);
    }

    public function payment(): HasOne
    {
        $model = Payment::getModel();

        $key = $this->model()->primaryKey($model);

        return $this->hasOne($model, $key, 'payment_id');
    }
}
