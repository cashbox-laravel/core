<?php

namespace Helldar\Cashier\Helpers;

use Helldar\Cashier\Facade\Config\Payment;
use Illuminate\Database\Eloquent\Model;

class Access
{
    public function allow(Model $model): bool
    {
        $types = $this->types();
        $type  = $this->type($model);

        return in_array($type, $types, true);
    }

    protected function types(): array
    {
        $assigned = Payment::assignDrivers();

        return array_keys($assigned);
    }

    protected function attribute(): string
    {
        return Payment::attributeType();
    }

    protected function type(Model $model)
    {
        $name = $this->attribute();

        return $model->getAttribute($name);
    }
}
