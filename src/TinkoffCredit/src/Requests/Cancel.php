<?php

declare(strict_types=1);

namespace CashierProvider\Tinkoff\Credit\Requests;

class Cancel extends BaseRequest
{
    protected $path = '/api/partners/v2/orders/{orderNumber}/cancel';

    protected $reload_relations = true;

    public function getRawBody(): array
    {
        return [];
    }
}
