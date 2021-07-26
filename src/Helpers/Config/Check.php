<?php

namespace Helldar\Cashier\Helpers\Config;

class Check extends Base
{
    public function delay(): int
    {
        $value = config('cashier.check.delay', 3);

        return $this->moduleValue($value);
    }

    public function timeout(): int
    {
        $value = config('cashier.check.timeout', 600);

        return $this->moduleValue($value);
    }
}
