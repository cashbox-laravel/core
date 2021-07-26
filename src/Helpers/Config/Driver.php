<?php

namespace Helldar\Cashier\Helpers\Config;

use Helldar\Cashier\Concerns\Validators;
use Helldar\Cashier\DTO\Config;
use Helldar\Cashier\Facades\Config\Payment as PaymentFacade;
use Helldar\Contracts\Cashier\Driver as DriverContract;
use Helldar\Support\Concerns\Resolvable;
use Helldar\Support\Facades\Helpers\Arr;
use Illuminate\Database\Eloquent\Model;

class Driver extends Base
{
    use Resolvable;
    use Validators;

    public function get(string $key, Model $model): DriverContract
    {
        return static::resolveCallback($key, function (string $key) use ($model) {
            $type = $this->type($key);

            $driver = $this->driver($type);

            return $this->resolveDriver($driver, $model);
        });
    }

    protected function type(string $driver): string
    {
        $drivers = PaymentFacade::assignDrivers();

        return Arr::get($drivers, $driver);
    }

    protected function driver(string $driver): array
    {
        return config('cashier.drivers.' . $driver);
    }

    /**
     * @param  array  $config
     * @param  \Helldar\Cashier\Concerns\Casheable|\Illuminate\Database\Eloquent\Model  $model
     *
     * @return \Helldar\Contracts\Cashier\Driver
     */
    protected function resolveDriver(array $config, Model $model): DriverContract
    {
        $config = Config::make($config);

        $driver = $config->getDriver();

        $this->validateDriver($driver);

        return $driver::make($config)->model($model);
    }
}
