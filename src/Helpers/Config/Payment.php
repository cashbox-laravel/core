<?php

namespace Helldar\Cashier\Helpers\Config;

use Helldar\Support\Facades\Helpers\Ables\Arrayable;
use Helldar\Support\Facades\Helpers\Arr;

class Payment extends Base
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

    public function attributeCurrency(): ?string
    {
        return config('cashier.payments.attributes.currency');
    }

    public function attributes(): array
    {
        return Arrayable::of([
            $this->attributeType(),
            $this->attributeStatus(),
            $this->attributeSum(),
            $this->attributeCurrency(),
        ])->filter()->values()->get();
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
