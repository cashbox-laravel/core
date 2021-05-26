<?php

namespace Helldar\Cashier\Exceptions;

use Helldar\Cashier\Contracts\Driver;
use RuntimeException;

final class IncorrectDriverException extends RuntimeException
{
    public function __construct(string $driver)
    {
        $message = 'The ' . $driver . ' class must implement ' . Driver::class;

        parent::__construct($message);
    }
}
