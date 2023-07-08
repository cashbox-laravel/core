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

use CashierProvider\Core\Data\Config\DetailsData;
use CashierProvider\Core\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Details extends Model
{
    protected $fillable = [
        'item_type',
        'item_id',
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
        $this->setConnection($this->connectionConfig()->connection);
        $this->setTable($this->connectionConfig()->table);

        parent::__construct($attributes);
    }

    public function parent(): Relation
    {
        return $this->morphTo('item');
    }

    protected function connectionConfig(): DetailsData
    {
        return Config::details();
    }
}
