<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Exceptions\Logic;

use Exception;
use Helldar\Cashier\Concerns\Exceptionable;
use Helldar\Contracts\Exceptions\LogicException;

abstract class BaseException extends Exception implements LogicException
{
    use Exceptionable;

    public $default_status_code = 400;

    public function __construct(string $payment_id)
    {
        $message = $this->getReason($payment_id);

        parent::__construct($message, $this->getStatus());
    }
}
