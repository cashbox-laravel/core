<?php

declare(strict_types=1);

namespace CashierProvider\BankName\Technology\Responses;

use CashierProvider\Core\Http\Response;

class Refund extends Response
{
    protected $map = [
        self::KEY_EXTERNAL_ID => 'PaymentId',

        self::KEY_STATUS => 'Status',
    ];
}
