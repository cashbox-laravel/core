<?php

namespace Helldar\Cashier\Models;

use Helldar\Cashier\DTO\Response;
use Helldar\Support\Facades\Helpers\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

final class CashierDetail extends Model
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

        return Response::make($decoded);
    }
}
