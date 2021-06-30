<?php

namespace Helldar\Cashier\Exceptions;

use Helldar\Cashier\Concerns\Casheable;
use RuntimeException;

class IncorrectPaymentModelException extends RuntimeException
{
    public function __construct(string $model)
    {
        $message = $model . ' must implement the' . Casheable::class . ' trait.';

        parent::__construct($message);
    }
}
