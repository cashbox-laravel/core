<?php

namespace Helldar\Cashier\Contracts;

interface Driver
{
    public function client(string $client_id): self;

    public function secret(string $secret): self;
}
