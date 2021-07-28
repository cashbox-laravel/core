<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Exceptions\Runtime\Implement;

use Helldar\Contracts\Cashier\Driver;

class IncorrectDriverException extends BaseImplementException
{
    protected $needle = Driver::class;
}
