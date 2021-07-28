<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions\Runtime;

use Helldar\Cashier\Concerns\Exceptionable;
use Helldar\Contracts\Exceptions\RuntimeException;

abstract class BaseException extends \RuntimeException implements RuntimeException
{
    use Exceptionable;

    public function __construct(...$values)
    {
        $message = $this->getReason(...$values);

        parent::__construct($message, $this->getStatus());
    }
}
