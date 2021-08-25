<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions\Http;

class SumException extends BaseException
{
    protected $status_code = 406;

    protected $reason = 'Amount must be greater than 0';
}
