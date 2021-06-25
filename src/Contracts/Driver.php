<?php

namespace Helldar\Cashier\Contracts;

interface Driver
{
    /** @return \Helldar\Cashier\Contracts\Driver */
    public static function make();

    public function auth(Auth $auth): self;

    public function statuses(): Statuses;

    public function host(): string;
}
