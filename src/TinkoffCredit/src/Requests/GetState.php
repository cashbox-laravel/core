<?php

declare(strict_types=1);

namespace CashierProvider\Tinkoff\Credit\Requests;

use Fig\Http\Message\RequestMethodInterface;

class GetState extends BaseRequest
{
    protected $method = RequestMethodInterface::METHOD_GET;

    protected $path = '/api/partners/v2/orders/{orderNumber}/info';

    public function getRawBody(): array
    {
        return [];
    }
}
