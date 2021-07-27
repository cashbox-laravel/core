<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Config;

use Helldar\Contracts\Cashier\Config\Driver as DriverContract;
use Helldar\SimpleDataTransferObject\DataTransferObject;

class Driver extends DataTransferObject implements DriverContract
{
    protected $driver;

    protected $resource;

    protected $client_id;

    protected $client_secret;

    public function getDriver(): string
    {
        return $this->driver;
    }

    public function getResource(): string
    {
        return $this->resource;
    }

    public function getClientId(): ?string
    {
        return $this->client_id;
    }

    public function getClientSecret(): ?string
    {
        return $this->client_secret;
    }
}
