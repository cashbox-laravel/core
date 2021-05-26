<?php

namespace Helldar\Cashier\Helpers;

use Helldar\Cashier\Contracts\Driver as Contract;
use Helldar\Cashier\Facade\Config\Driver as DriverConfig;
use Helldar\Cashier\Facade\Config\Payment;
use Illuminate\Database\Eloquent\Model;

final class Driver
{
    public function fromModel(Model $model): Contract
    {
        $type = $this->type($model);

        return DriverConfig::get($type);
    }

    protected function type(Model $model): string
    {
        $field = $this->typeField();

        return $model->getAttribute($field);
    }

    protected function typeField(): string
    {
        return Payment::attributeType();
    }
}
