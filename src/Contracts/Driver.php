<?php

namespace Helldar\Cashier\Contracts;

interface Driver
{
    /** @return \Helldar\Cashier\Contracts\Driver */
    public static function make();

    public function client(string $client_id): self;

    public function secret(string $secret): self;

    public function statuses(): Statuses;

    public function host(): string;
}
