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

namespace CashierProvider\Manager\Models;

use CashierProvider\Manager\Facades\Config\Logs;
use Helldar\LaravelSupport\Traits\InitModelHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property \CashierProvider\Manager\Concerns\Casheable|\Illuminate\Database\Eloquent\Model $payment
 * @property array $extra
 * @property array $request
 * @property array $response
 * @property float $sum
 * @property int $status_code
 * @property string $currency
 * @property string $external_id
 * @property string $method
 * @property string $url
 * @property int|string $item_id
 * @property int|string $item_type
 */
class CashierLog extends Model
{
    use InitModelHelper;

    protected $fillable = ['item_type', 'item_id', 'external_id', 'method', 'url', 'status_code', 'request', 'response', 'extra'];

    protected $casts = [
        'status_code' => 'integer',

        'external_id' => 'string',

        'request'  => 'json',
        'response' => 'json',
        'extra'    => 'json',
    ];

    public function __construct(array $attributes = [])
    {
        $this->setConnection(Logs::getConnection());

        $this->setTable(Logs::getTable());

        parent::__construct($attributes);
    }

    public function parent(): MorphTo
    {
        return $this->morphTo('item');
    }
}
