<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Exceptions\Client;

class BadRequestClientException extends BaseClientException
{
    protected $status_code = 400;

    protected $reason = 'Bad Request';
}
