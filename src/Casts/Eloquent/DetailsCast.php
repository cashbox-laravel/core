<?php

declare(strict_types=1);

namespace CashierProvider\Core\Casts\Eloquent;

use CashierProvider\Core\Resources\Details;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class DetailsCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?Details
    {
        return $model->parent->cashierDriver()->details(
            json_decode($value)
        );
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        return $value?->toJson();
    }
}
