<?php

declare(strict_types=1);

namespace CashierProvider\BankName\Technology\Responses;

use CashierProvider\Core\Http\Response;

class State extends Response
{
    protected $map = [
        self::KEY_EXTERNAL_ID => 'PaymentId',

        self::KEY_STATUS => 'Status',
    ];

    public function isEmpty(): bool
    {
        return empty($this->getExternalId()) || empty($this->getStatus());
    }
}
