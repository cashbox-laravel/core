<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions\Runtime\Implement;

use Helldar\Contracts\Cashier\Resources\Response;

class UnknownResponseException extends BaseImplementException
{
    protected $needle = Response::class;
}
