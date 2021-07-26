<?php

namespace Helldar\Cashier\Helpers;

use Helldar\Cashier\Facades\Config\Driver as DriverConfig;
use Helldar\Cashier\Facades\Config\Payment;
use Helldar\Contracts\Cashier\Driver as Contract;
use Illuminate\Database\Eloquent\Model;

class Driver
{
    /**
     * @param  \Helldar\Cashier\Concerns\Casheable|\Illuminate\Database\Eloquent\Model  $model
     *
     * @return \Helldar\Contracts\Cashier\Driver
     */
    public function fromModel(Model $model): Contract
    {
        $type = $this->type($model);

        return DriverConfig::get($type, $model);
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
