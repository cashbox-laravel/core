<?php

namespace Helldar\Cashier\Services;

use Helldar\Cashier\Concerns\Resolvable;
use Helldar\Cashier\Concerns\Validators;
use Helldar\Cashier\Contracts\Driver as Contract;
use Helldar\Cashier\Contracts\Statuses;
use Helldar\Cashier\Facade\Config\Main;
use Helldar\Support\Concerns\Makeable;

abstract class Driver implements Contract
{
    use Makeable;
    use Resolvable;
    use Validators;

    /** @var \Helldar\Cashier\Contracts\Statuses|string */
    protected $statuses;

    protected $client_id;

    protected $secret;

    protected $production_host;

    protected $dev_host;

    public function client(string $client_id): Contract
    {
        $this->client_id = $client_id;

        return $this;
    }

    public function secret(string $secret): Contract
    {
        $this->secret = $secret;

        return $this;
    }

    public function statuses(): Statuses
    {
        return $this->resolve($this->statuses, function ($statuses) {
            $this->validateStatuses($statuses);

            return new $statuses;
        });
    }

    public function host(): string
    {
        return Main::hasProduction() ? $this->production_host : $this->dev_host;
    }
}
