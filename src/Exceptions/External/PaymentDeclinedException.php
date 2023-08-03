<?php

declare(strict_types=1);

namespace Cashbox\Core\Exceptions\External;

use Cashbox\Core\Exceptions\BaseException;

class PaymentDeclinedException extends BaseException
{
    protected int $statusCode = 403;

    protected string $reason = 'Payment declined';
}
