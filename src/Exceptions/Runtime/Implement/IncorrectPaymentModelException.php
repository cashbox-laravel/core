<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Exceptions\Runtime\Implement;

use Helldar\Cashier\Concerns\Casheable;

class IncorrectPaymentModelException extends BaseImplementException
{
    protected $needle = Casheable::class;
}
