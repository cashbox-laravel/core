<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Exceptions\Logic;

class AlreadyRefundedException extends BaseException
{
    protected $status_code = 409;

    protected $reason = 'Funds for payment #%s have already been returned';
}
