<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions\Http;

class TryAgainLaterClientException extends BaseException
{
    protected $status_code = 449;

    protected $reason = 'Please Try Again Later';
}
