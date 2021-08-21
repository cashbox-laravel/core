<?php

namespace Helldar\Cashier\Exceptions\Http;

class UnauthorizedException extends BaseException
{
    protected $status_code = 401;

    protected $reason = 'Unauthorized';
}
