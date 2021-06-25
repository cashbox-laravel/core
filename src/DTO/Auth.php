<?php

namespace Helldar\Cashier\DTO;

use Helldar\Cashier\Contracts\Auth as Contract;
use Helldar\Support\Concerns\Makeable;

class Auth implements Contract
{
    use Makeable;

    protected $client_id;

    protected $client_secret;

    public function setClientId(?string $id): Contract
    {
        $this->client_id = $id;

        return $this;
    }

    public function getClientId(): string
    {
        return $this->client_id;
    }

    public function setClientSecret(?string $secret): Contract
    {
        $this->client_secret = $secret;

        return $this;
    }

    public function getClientSecret(): string
    {
        return $this->client_secret;
    }

    public function doesntEmpty(): bool
    {
        return ! empty($this->client_id) && ! empty($this->client_secret);
    }
}
