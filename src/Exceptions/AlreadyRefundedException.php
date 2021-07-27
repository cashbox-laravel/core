<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions;

use Exception;

class AlreadyRefundedException extends Exception
{
    public function __construct(string $payment_id)
    {
        $message = "Funds for payment #$payment_id have already been returned";

        parent::__construct($message, 409);
    }
}
