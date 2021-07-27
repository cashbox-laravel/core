<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions\Client;

class TryAgainLaterClientException extends BaseClientException
{
    protected $status_code = 449;

    protected $reason = 'Please Try Again Later';
}
