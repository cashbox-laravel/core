<?php

namespace Helldar\Cashier\Exceptions\Client;

class BadRequestClientException extends BaseClientException
{
    protected $status_code = 400;

    protected $reason = 'Bad Request';
}
