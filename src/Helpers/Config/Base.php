<?php

namespace Helldar\Cashier\Helpers\Config;

abstract class Base
{
    protected function fixDelay(int $value): int
    {
        return abs($value);
    }
}
