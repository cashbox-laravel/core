<?php

declare(strict_types=1);

namespace Helldar\Cashier\Models;

use Helldar\Cashier\Facades\Config\Details;
use Helldar\Cashier\Facades\Helpers\DriverManager;
use Helldar\Cashier\Facades\Helpers\JSON;
use Helldar\Contracts\Cashier\Resources\Details as DetailsCast;
use Helldar\LaravelSupport\Eloquent\CompositeKeysModel;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property \Helldar\Contracts\Cashier\Resources\Details $details
 * @property \Illuminate\Database\Eloquent\Model $parent
 */
class CashierDetail extends CompositeKeysModel
{
    protected $primaryKey = ['item_type', 'item_id'];

    protected $fillable = ['item_type', 'item_id', 'payment_id', 'details'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(Details::getTable());
    }

    public function parent(): MorphTo
    {
        return $this->morphTo('item');
    }

    protected function setDetailsAttribute(DetailsCast $details): void
    {
        $this->attributes['details'] = $details->toJson();
    }

    protected function getDetailsAttribute(): DetailsCast
    {
        $decoded = JSON::decode($this->attributes['details']);

        return DriverManager::fromModel($this->parent)->modelDetails($decoded);
    }
}
