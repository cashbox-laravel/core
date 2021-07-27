<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Exceptions;

class PaymentInProgressException extends \Exception
{
    public function __construct(string $payment_id)
    {
        $message = 'Payment #' . $payment_id . ' is being processed.';

        parent::__construct($message, 425);
    }
}
