<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions\Http;

class PaymentDeclinedException extends BaseException
{
    protected $status_code = 406;

    protected $reason = 'Payment declined by the bank';
}
