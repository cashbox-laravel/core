<?php

namespace Helldar\Cashier\Helpers\Config;

use Helldar\Cashier\Concerns\Resolvable;
use Helldar\Cashier\Concerns\Validators;
use Helldar\Cashier\Contracts\Driver as Contract;
use Helldar\Cashier\Facade\Config\Payment as PaymentFacade;
use Helldar\Support\Facades\Helpers\Arr;

final class Driver extends Base
{
    use Resolvable;
    use Validators;

    public function get(string $key): Contract
    {
        return $this->resolve($key, function (string $key) {
            $type = $this->type($key);

            $driver = $this->driver($type);

            return $this->resolveDriver($driver);
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

    protected function resolveDriver(array $config): Contract
    {
        /**
         * @var Contract|string $driver
         * @var string $client
         * @var string $secret
         */
        extract($config);

        $this->validateDriver($driver);

        return $driver::make()->client($client)->secret($secret);
    }
}
