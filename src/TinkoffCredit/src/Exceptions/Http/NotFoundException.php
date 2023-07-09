<?php

namespace CashierProvider\Tinkoff\Credit\Exceptions\Http;

use CashierProvider\Core\Exceptions\Http\BaseException;

class NotFoundException extends BaseException
{
    protected $status_code = 404;

    protected $reason = 'Payment not found';
}
