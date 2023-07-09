<?php

namespace CashierProvider\Tinkoff\Credit\Exceptions\Http;

use CashierProvider\Core\Exceptions\Http\BaseException;

class CancelDeniedException extends BaseException
{
    protected $status_code = 403;

    protected $reason = 'Payment not found';
}
