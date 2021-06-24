<?php

namespace Helldar\Cashier\Contracts;

interface Config
{
    public function setClientId(string $client_id): self;

    public function getClientId(): string;

    public function setClientSecret(string $client_secret): self;

    public function getClientSecret(): string;

    public function setPaymentId($payment_id): self;

    public function getPaymentId();

    public function setUniqueId($unique_id): self;

    public function getUniqueId();
}
