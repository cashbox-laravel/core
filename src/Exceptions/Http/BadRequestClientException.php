<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions\Http;

class BadRequestClientException extends BaseException
{
    protected $status_code = 400;

    protected $reason = 'Bad Request';
}
