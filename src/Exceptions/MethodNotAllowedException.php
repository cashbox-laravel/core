<?php

namespace Helldar\Cashier\Exceptions;

use RuntimeException;

final class MethodNotAllowedException extends RuntimeException
{
    public function __construct(string $method)
    {
        $message = 'Method "' . $method . '" not allowed!';

        parent::__construct($message);
    }
}
