<?php

declare(strict_types=1);

namespace Cashbox\Core\Exceptions\Internal;

use Cashbox\Core\Exceptions\BaseException;

class IncorrectDriverException extends BaseException
{
    protected string $reason = 'The "%s" class must implement "%s".';
}
