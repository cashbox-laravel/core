<?php

namespace Helldar\Cashier\Helpers\Config;

abstract class Base
{
    protected function moduleValue(int $value): int
    {
        return abs($value);
    }
}
