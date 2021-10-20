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

use CashierProvider\Manager\Concerns\Relations;
use CashierProvider\Manager\Facades\Config\Details;
use CashierProvider\Manager\Facades\Helpers\DriverManager;
use CashierProvider\Manager\Facades\Helpers\JSON;
use Helldar\Contracts\Cashier\Resources\Details as DetailsCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property \Helldar\Contracts\Cashier\Resources\Details $details
 * @property \Illuminate\Database\Eloquent\Model $parent
 * @property array|null $extra
 * @property string $external_id
 * @property string $item_type
 * @property string $operation_id
 * @property int|string $item_id
 */
class CashierDetail extends Model
{
    use Relations;

    protected $fillable = ['item_type', 'item_id', 'external_id', 'operation_id', 'details'];

    protected $touches = ['parent'];

    public function __construct(array $attributes = [])
    {
        $this->setTable(Details::getTable());

        parent::__construct($attributes);
    }

    public function parent(): MorphTo
    {
        return $this->morphTo('item');
    }

    protected function setDetailsAttribute(DetailsCast $details = null): void
    {
        $this->attributes['details'] = $details ? $details->toJson() : null;
    }

    protected function getDetailsAttribute(): ?DetailsCast
    {
        $this->resolvePayment($this);

        $decoded = JSON::decode($this->attributes['details']);

        return DriverManager::fromModel($this->parent)->details($decoded);
    }
}
