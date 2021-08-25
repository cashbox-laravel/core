<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions\Http;

class InvalidCardException extends BaseException
{
    protected $status_code = 406;

    protected $reason = 'The card is invalid. Contact the bank that issued the card.';
}
