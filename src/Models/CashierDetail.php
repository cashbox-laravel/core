<?php

namespace Helldar\Cashier\Models;

use Helldar\Cashier\Facades\Helpers\Driver;
use Helldar\Cashier\Resources\Response;
use Helldar\LaravelSupport\Eloquent\CompositeKeysModel;
use Helldar\Support\Facades\Helpers\Arr;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property \Helldar\Cashier\Resources\Response $details
 */
class CashierDetail extends CompositeKeysModel
{
    protected $primaryKey = ['item_type', 'item_id'];

    protected $fillable = ['item_type', 'item_id', 'payment_id', 'details'];

    public function parent(): MorphTo
    {
        return $this->morphTo('item');
    }

    protected function setDetailsAttribute(Response $response): void
    {
        $data = Arr::toArray($response);

        $this->attributes['details'] = json_encode($data);
    }

    protected function getDetailsAttribute(): Response
    {
        $decoded = json_decode($this->attributes['details'], true);

        return $this->getCashierResponseFromDriver($decoded);
    }

    protected function getCashierResponseFromDriver(array $data): Response
    {
        return Driver::fromModel($this->parent)->response($data, false);
    }
}
