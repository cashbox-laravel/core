<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions;

class EmptyResponseException extends \Exception
{
    public function __construct()
    {
        parent::__construct('The bank returned an empty response', 400);
    }
}
