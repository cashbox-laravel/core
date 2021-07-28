<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Exceptions\Runtime;

/** @method UnknownMethodException __construct(string $class, string $method) */
class UnknownMethodException extends BaseException
{
    protected $reason = 'The %s class does not contain a "%s" method.';
}
