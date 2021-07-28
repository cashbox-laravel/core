<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions\Runtime;

/** @method UnknownPropertyException __construct(string $name) */
class UnknownPropertyException extends BaseException
{
    protected $reason = 'Property "%s" not found';
}
