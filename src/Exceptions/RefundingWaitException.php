<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Exceptions;

use Exception;

class RefundingWaitException extends Exception
{
    public function __construct(string $payment_id)
    {
        $message = "The url could not be displayed because a refund is pending for payment #$payment_id.";

        parent::__construct($message, 409);
    }
}
