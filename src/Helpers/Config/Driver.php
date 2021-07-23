<?php

namespace Helldar\Cashier\Helpers\Config;

use Helldar\Cashier\Concerns\Resolvable;
use Helldar\Cashier\Concerns\Validators;
use Helldar\Cashier\Contracts\Auth as AuthContract;
use Helldar\Cashier\Contracts\Driver as DriverContract;
use Helldar\Cashier\DTO\Auth;
use Helldar\Cashier\DTO\Config;
use Helldar\Cashier\Facades\Config\Payment as PaymentFacade;
use Helldar\Support\Facades\Helpers\Arr;
use Illuminate\Database\Eloquent\Model;

class Driver extends Base
{
    use Resolvable;
    use Validators;

    public function get(string $key, Model $model): DriverContract
    {
        return $this->resolve($key, function (string $key) use ($model) {
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
     * @return \Helldar\Cashier\Contracts\Driver
     */
    protected function resolveDriver(array $config, Model $model): DriverContract
    {
        $config = Config::make($config);

        $driver = $config->getDriver();

        $this->validateDriver($driver);

        $auth = $this->resolveAuth($model, $config->getClientId(), $config->getClientSecret());

        return $driver::make()->model($model, $config->getRequest())->auth($auth);
    }

    protected function resolveAuth(Model $model, ?string $client_id, ?string $client_secret): AuthContract
    {
        $auth = $this->resolveModelAuth($model);

        if ($auth->doesntEmpty()) {
            return $auth;
        }

        return $auth
            ->setClientId($client_id)
            ->setClientSecret($client_secret);
    }

    protected function resolveModelAuth(Model $model): AuthContract
    {
        if (method_exists($model, 'cashierAuth')) {
            return $model->cashierAuth();
        }

        return Auth::make();
    }
}
