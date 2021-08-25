<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions\Http;

class CardHasStolenException extends BaseException
{
    protected $status_code = 451;

    protected $reason = 'The card has been stolen. Contact the bank that issued the card.';
}
