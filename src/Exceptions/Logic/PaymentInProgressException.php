<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions\Logic;

class PaymentInProgressException extends BaseException
{
    protected $status_code = 425;

    protected $reason = 'Payment #%s is being processed.';
}
