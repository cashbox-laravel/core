<?php

namespace Helldar\Cashier\Helpers;

use Helldar\Cashier\Facades\Config\Payment;
use Helldar\Support\Facades\Helpers\Instance;
use Illuminate\Database\Eloquent\Model;

class Access
{
    public function allow(Model $model): bool
    {
        return $this->allowModel($model)
            && $this->allowType($model)
            && $this->allowMethod($model);
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

    protected function allowType(Model $model): bool
    {
        $types = $this->types();
        $type  = $this->type($model);

        return in_array($type, $types, true);
    }

    protected function model(): string
    {
        return Payment::model();
    }

    protected function allowModel(Model $model): bool
    {
        return Instance::of($model, $this->model());
    }

    protected function allowMethod(Model $model): bool
    {
        return method_exists($model, 'cashier');
    }
}
