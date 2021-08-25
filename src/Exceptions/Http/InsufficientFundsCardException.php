<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions\Http;

class InsufficientFundsCardException extends BaseException
{
    protected $status_code = 402;

    protected $reason = 'Insufficient funds on the card.';
}
