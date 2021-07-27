<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Exceptions;

use RuntimeException;

class MethodNotAllowedException extends RuntimeException
{
    public function __construct(string $method)
    {
        $message = 'Method "' . $method . '" not allowed!';

        parent::__construct($message);
    }
}
