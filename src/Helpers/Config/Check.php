<?php

namespace Helldar\Cashier\Helpers\Config;

final class Check extends Base
{
    public function delay(): int
    {
        $value = config('cashier.check.delay');

        return $this->fixDelay($value);
    }

    public function timeout(): int
    {
        $value = config('cashier.check.timeout');

        return $this->fixDelay($value);
    }
}
