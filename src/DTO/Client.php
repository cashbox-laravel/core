<?php

namespace Helldar\Cashier\DTO;

use Helldar\Contracts\Cashier\Authentication\Client as Contract;
use Helldar\Support\Concerns\Makeable;

class Client implements Contract
{
    use Makeable;

    protected $client_id;

    protected $client_secret;

    public function getClientId(): ?string
    {
        return $this->client_id;
    }

    public function setClientId(?string $client_id): Contract
    {
        $this->client_id = $client_id;

        return $this;
    }

    public function getClientSecret(): ?string
    {
        return $this->client_secret;
    }

    public function setClientSecret(?string $client_secret): Contract
    {
        $this->client_secret = $client_secret;

        return $this;
    }

    public function doesntEmpty(): bool
    {
        return ! $this->getClientId() && ! $this->getClientSecret();
    }
}
