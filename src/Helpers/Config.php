<?php

namespace Helldar\Cashier\Helpers;

use Helldar\Cashier\Contracts\Config as Contract;

class Config implements Contract
{
    protected $client_id;

    protected $client_secret;

    protected $payment_id;

    protected $unique_id;

    public function getClientId(): string
    {
        return $this->client_id;
    }

    public function setClientId(string $client_id): Contract
    {
        $this->client_id = $client_id;

        return $this;
    }

    public function getClientSecret(): string
    {
        return $this->client_secret;
    }

    public function setClientSecret(string $client_secret): Contract
    {
        $this->client_secret = $client_secret;

        return $this;
    }

    public function getPaymentId()
    {
        return $this->payment_id;
    }

    public function setPaymentId($payment_id): Contract
    {
        $this->payment_id = $payment_id;

        return $this;
    }

    public function getUniqueId()
    {
        return $this->unique_id;
    }

    public function setUniqueId($unique_id): Contract
    {
        $this->unique_id = $unique_id;

        return $this;
    }
}
