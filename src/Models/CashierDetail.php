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

use Helldar\Cashier\Concerns\Relations;
use Helldar\Cashier\Facades\Config\Details;
use Helldar\Cashier\Facades\Helpers\DriverManager;
use Helldar\Cashier\Facades\Helpers\JSON;
use Helldar\Contracts\Cashier\Resources\Details as DetailsCast;
use Helldar\LaravelSupport\Eloquent\CompositeKeysModel;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property \Helldar\Contracts\Cashier\Resources\Details $details
 * @property \Illuminate\Database\Eloquent\Model $parent
 * @property string $external_id
 */
class CashierDetail extends CompositeKeysModel
{
    use Relations;

    protected $primaryKey = ['item_type', 'item_id'];

    protected $fillable = ['item_type', 'item_id', 'external_id', 'details'];

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

        return DriverManager::fromModel($this->parent)->details($decoded ?: []);
    }
}
