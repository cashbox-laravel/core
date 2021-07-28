<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Exceptions\Logic;

class RefundingWaitException extends BaseException
{
    protected $status_code = 409;

    protected $reason = 'The url could not be displayed because a refund is pending for payment #%s';
}
