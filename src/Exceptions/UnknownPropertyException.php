<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions;

use RuntimeException;

class UnknownPropertyException extends RuntimeException
{
    public function __construct(string $name)
    {
        $message = 'Property "' . $name . '" not found.';

        parent::__construct($message);
    }
}
