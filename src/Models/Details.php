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

use CashierProvider\Core\Concerns\Config\Details as DetailsConcern;
use CashierProvider\Core\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Details extends Model
{
    use DetailsConcern;

    protected $fillable = [
        'payment_id',
        'external_id',
        'operation_id',
        'info',
    ];

    protected $casts = [
        'info' => 'json',
    ];

    protected $touches = [
        'parent',
    ];

    public function __construct(array $attributes = [])
    {
        $this->setConnection(static::details()->connection);
        $this->setTable(static::details()->table);

        parent::__construct($attributes);
    }

    public function parent(): Relation
    {
        return $this->belongsTo(Config::payment()->model, 'id', 'payment_id');
    }
}
