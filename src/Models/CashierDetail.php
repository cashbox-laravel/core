<?php

namespace Helldar\Cashier\Models;

use Helldar\Cashier\Facades\Helpers\Driver;
use Helldar\Cashier\Resources\Response;
use Helldar\Support\Facades\Helpers\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CashierDetail extends Model
{
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
        $decoded = json_decode($this->attributes['details']);

        return $this->getCashierResponseFromDriver($decoded);
    }

    protected function getCashierResponseFromDriver(array $data): Response
    {
        return Driver::fromModel($this)->response($data);
    }
}
