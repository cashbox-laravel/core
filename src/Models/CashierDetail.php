<?php

/**
 * This file is part of the "cashier-provider/core" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider
 */

declare(strict_types=1);

namespace CashierProvider\Core\Models;

use CashierProvider\Core\Casts\Eloquent\DetailsCast;
use CashierProvider\Core\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property \CashierProvider\Core\Resources\Details $details
 * @property \Illuminate\Database\Eloquent\Model|\CashierProvider\Core\Concerns\Casheable $parent
 * @property array|null $extra
 * @property string $external_id
 * @property string $item_type
 * @property string $operation_id
 * @property int|string $item_id
 */
class CashierDetail extends Model
{
    protected $fillable = [
        'item_type',
        'item_id',
        'external_id',
        'operation_id',
        'details',
    ];

    protected $casts = [
        'details' => DetailsCast::class,
    ];

    protected $touches = [
        'parent',
    ];

    public function __construct(array $attributes = [])
    {
        $details = Config::details();

        $this->setConnection($details->connection);
        $this->setTable($details->table);

        parent::__construct($attributes);
    }

    public function parent(): MorphTo
    {
        return $this->morphTo('item');
    }
}
