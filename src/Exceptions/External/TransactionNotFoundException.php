<?php

declare(strict_types=1);

namespace Cashbox\Core\Exceptions\External;

use Cashbox\Core\Exceptions\BaseException;

class TransactionNotFoundException extends BaseException
{
    protected int $statusCode = 404;

    protected string $reason = 'Not Found';
}
