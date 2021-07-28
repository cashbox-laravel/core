<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions\Http;

class BankInternalErrorException extends BaseException
{
    protected $status_code = 400;

    protected $reason = 'Internal error of the bank system';
}
