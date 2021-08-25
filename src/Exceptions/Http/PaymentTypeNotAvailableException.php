<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions\Http;

class PaymentTypeNotAvailableException extends BaseException
{
    protected $status_code = 423;

    protected $reason = 'Payment type not available';
}
