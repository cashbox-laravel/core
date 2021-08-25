<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions\Http;

class CardDeclinedException extends BaseException
{
    protected $status_code = 406;

    protected $reason = 'Card declined by the bank';
}
