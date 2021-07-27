<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Config;

abstract class Base
{
    protected function moduleValue(int $value): int
    {
        return (int) abs($value);
    }
}
