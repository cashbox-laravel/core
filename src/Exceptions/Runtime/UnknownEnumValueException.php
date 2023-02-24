<?php

declare(strict_types=1);

namespace CashierProvider\Core\Exceptions\Runtime;

class UnknownEnumValueException extends BaseException
{
    protected string $reason = 'Unknown enum value: "%s"';
}
