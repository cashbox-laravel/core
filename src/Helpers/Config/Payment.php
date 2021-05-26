<?php

namespace Helldar\Cashier\Helpers\Config;

use Illuminate\Database\Eloquent\Model;

final class Payment extends Base
{
    public function model(): Model
    {
        $model = config('cashier.payments.model');

        return new $model;
    }

    public function attributeType(): string
    {
        return config('cashier.payments.attributes.type');
    }

    public function attributeStatus(): string
    {
        return config('cashier.payments.attributes.status');
    }

    public function attributeSum(): string
    {
        return config('cashier.payments.attributes.sum');
    }

    public function statuses(): array
    {
        return config('cashier.payments.statuses');
    }

    public function assignDrivers(): array
    {
        return config('cashier.payments.assign_drivers');
    }
}
