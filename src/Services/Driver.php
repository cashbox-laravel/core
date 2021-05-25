<?php

namespace Helldar\Cashier\Services;

use Helldar\Cashier\Contracts\Driver as Contract;

abstract class Driver implements Contract
{
    protected $client_id;

    protected $secret;

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
}
