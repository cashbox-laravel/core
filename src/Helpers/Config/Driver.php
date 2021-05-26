<?php

namespace Helldar\Cashier\Helpers\Config;

use Helldar\Cashier\Concerns\Resolvable;
use Helldar\Cashier\Contracts\Driver as Contract;
use Helldar\Cashier\Exceptions\IncorrectDriverException;
use Helldar\Cashier\Facade\Config\Payment as PaymentFacade;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Instance;

final class Driver extends Base
{
    use Resolvable;

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
         * @var Contract $driver
         * @var string $client
         * @var string $secret
         */
        extract($config);

        $this->validateDriver($driver);

        return $driver::make()->client($client)->secret($secret);
    }

    /**
     * @param  \Helldar\Cashier\Contracts\Driver|string  $driver
     */
    protected function validateDriver(string $driver): void
    {
        if (! Instance::of($driver, Contract::class)) {
            throw new IncorrectDriverException($driver);
        }
    }
}
