<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions\Logic;

class EmptyResponseException extends BaseException
{
    protected $reason = 'The bank returned an empty response';
}
