<?php

namespace Helldar\Cashier\Exceptions;

use RuntimeException;

final class UnknownPropertyException extends RuntimeException
{
    public function __construct(string $name)
    {
        $message = 'Property "' . $name . '" not found.';

        parent::__construct($message);
    }
}
