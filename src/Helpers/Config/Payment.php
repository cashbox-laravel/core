<?php

namespace Helldar\Cashier\Helpers\Config;

use Helldar\Support\Facades\Helpers\Arr;

final class Payment extends Base
{
    public function model(): string
    {
        return config('cashier.payments.model');
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

    public function attributes(): array
    {
        return [
            $this->attributeType(),
            $this->attributeStatus(),
            $this->attributeSum(),
        ];
    }

    public function statuses(): array
    {
        return config('cashier.payments.statuses');
    }

    public function status(string $status)
    {
        return Arr::get($this->statuses(), $status);
    }

    public function assignDrivers(): array
    {
        return config('cashier.payments.assign_drivers');
    }
}
