<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions\Http;

class BuyerNotFoundClientException extends BaseException
{
    protected $status_code = 404;

    protected $reason = 'Buyer Not Found';
}
