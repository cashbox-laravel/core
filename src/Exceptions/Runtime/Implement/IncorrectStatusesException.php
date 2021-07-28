<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Exceptions\Runtime\Implement;

use Helldar\Contracts\Cashier\Helpers\Statuses;

class IncorrectStatusesException extends BaseImplementException
{
    protected $needle = Statuses::class;
}
