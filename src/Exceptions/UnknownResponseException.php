<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions;

use Helldar\Cashier\Resources\Response;

class UnknownResponseException extends \RuntimeException
{
    public function __construct(string $class)
    {
        $message = 'The ' . $class . ' class must extends of ' . Response::class;

        parent::__construct($message);
    }
}
