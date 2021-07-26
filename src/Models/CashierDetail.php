<?php

namespace Helldar\Cashier\Models;

use Helldar\Cashier\Facades\Config\Main;
use Helldar\Cashier\Facades\Helpers\Driver;
use Helldar\Cashier\Facades\JSON;
use Helldar\Contracts\Cashier\Resources\Response;
use Helldar\LaravelSupport\Eloquent\CompositeKeysModel;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property \Helldar\Contracts\Cashier\Resources\Response $details
 * @property \Illuminate\Database\Eloquent\Model $parent
 */
class CashierDetail extends CompositeKeysModel
{
    protected $primaryKey = ['item_type', 'item_id'];

    protected $fillable = ['item_type', 'item_id', 'payment_id', 'details'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(Main::tableDetails());
    }

    public function parent(): MorphTo
    {
        return $this->morphTo('item');
    }

    protected function setDetailsAttribute(Response $response): void
    {
        $this->attributes['details'] = JSON::encode($response);
    }

    protected function getDetailsAttribute(): Response
    {
        $decoded = JSON::decode($this->attributes['details']);

        return $this->getCashierResponseFromDriver($decoded);
    }

    protected function getCashierResponseFromDriver(array $data): Response
    {
        return Driver::fromModel($this->parent)->response($data, false);
    }
}
