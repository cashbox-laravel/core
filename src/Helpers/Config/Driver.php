<?php

namespace Helldar\Cashier\Helpers\Config;

use Helldar\Cashier\Concerns\Resolvable;
use Helldar\Cashier\Concerns\Validators;
use Helldar\Cashier\Contracts\Auth as AuthContract;
use Helldar\Cashier\Contracts\Driver as DriverContract;
use Helldar\Cashier\DTO\Auth;
use Helldar\Cashier\Facade\Config\Payment as PaymentFacade;
use Helldar\Support\Facades\Helpers\Arr;
use Illuminate\Database\Eloquent\Model;

final class Driver extends Base
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
     * @param  \Illuminate\Database\Eloquent\Model|\Helldar\Cashier\Concerns\Casheable  $model
     *
     * @return \Helldar\Cashier\Contracts\Driver
     */
    protected function resolveDriver(array $config, Model $model): DriverContract
    {
        /**
         * @var DriverContract|string $driver
         * @var string $map
         * @var string $client_id
         * @var string $client_secret
         */
        extract($config);

        $this->validateDriver($driver);

        $auth = $this->resolveAuth($model, $client_id, $client_secret);

        return $driver::make()->model($model, $map)->auth($auth);
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
