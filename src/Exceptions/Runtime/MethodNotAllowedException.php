<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions\Runtime;

/** @method MethodNotAllowedException __construct(string $method) */
class MethodNotAllowedException extends BaseException
{
    protected $reason = 'Method "%s" not allowed!';
}
