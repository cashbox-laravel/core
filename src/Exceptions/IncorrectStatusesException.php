<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Exceptions;

use Helldar\Cashier\Contracts\Statuses;
use RuntimeException;

class IncorrectStatusesException extends RuntimeException
{
    public function __construct(string $class)
    {
        $message = 'The ' . $class . ' class must implement ' . Statuses::class;

        parent::__construct($message);
    }
}
