<?php

/*
 * This file is part of the "cashier-provider/core" project.
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
 * @see https://github.com/cashier-provider/core
 */

declare(strict_types=1);

namespace CashierProvider\Core\Models;

use CashierProvider\Core\Facades\Config;
use CashierProvider\Core\Facades\DriverManager;
use DragonCode\Contracts\Cashier\Resources\Details as DetailsCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property \CashierProvider\Core\Resources\Details $details
 * @property \Illuminate\Database\Eloquent\Model $parent
 * @property array|null $extra
 * @property string $external_id
 * @property string $item_type
 * @property string $operation_id
 * @property int|string $item_id
 */
class CashierDetail extends Model
{
    protected $fillable = ['item_type', 'item_id', 'external_id', 'operation_id', 'details'];

    protected $touches = ['parent'];

    public function __construct(array $attributes = [])
    {
        $this->setConnection(Config::details()->connection);
        $this->setTable(Config::details()->table);

        parent::__construct($attributes);
    }

    public function parent(): MorphTo
    {
        return $this->morphTo('item');
    }

    protected function setDetailsAttribute(?DetailsCast $details = null): void
    {
        $this->attributes['details'] = $details?->toJson();
    }

    protected function getDetailsAttribute(): ?DetailsCast
    {
        return DriverManager::fromModel($this->parent)->details(
            json_decode($this->attributes['details'])
        );
    }
}
