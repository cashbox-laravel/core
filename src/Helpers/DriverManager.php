<?php

declare(strict_types=1);

namespace Helldar\Cashier\Helpers;

use Helldar\Cashier\Concerns\Validators;
use Helldar\Cashier\Facades\Config\Main;
use Helldar\Cashier\Facades\Config\Payment;
use Helldar\Contracts\Cashier\Config\Driver;
use Helldar\Contracts\Cashier\Driver as Contract;
use Illuminate\Database\Eloquent\Model;

class DriverManager
{
    use Validators;

    /**
     * @param  \Helldar\Cashier\Concerns\Casheable|\Illuminate\Database\Eloquent\Model  $model
     *
     * @return \Helldar\Contracts\Cashier\Driver
     */
    public function fromModel(Model $model): Contract
    {
        $this->validateModel($model);

        $type = $this->type($model);

        $name = $this->getDriverName($type);

        $driver = $this->getDriver($name);

        return $this->resolve($driver, $model);
    }

    protected function type(Model $model): string
    {
        $type = $this->getTypeAttribute();

        return $model->getAttribute($type);
    }

    protected function getTypeAttribute(): string
    {
        return Payment::getAttributes()->getType();
    }

    protected function getDriverName($type): string
    {
        return Payment::getMap()->get($type);
    }

    protected function getDriver(string $name): Driver
    {
        return Main::getDriver($name);
    }

    protected function resolve(Driver $config, Model $payment): Contract
    {
        $driver = $config->getDriver();

        $this->validateDriver($driver);
        $this->validateModel($payment);

        return $driver::make($config, $payment);
    }
}
