<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use CashierProvider\Core\Http\Request as BaseRequest;

class Request extends BaseRequest
{
    public function getRawHeaders(): array
    {
        return ['Accept' => 'application/json'];
    }

    public function getRawBody(): array
    {
        return [
            'PaymentId' => $this->model->getPaymentId(),
            'Sum'       => $this->model->getSum(),
            'Currency'  => $this->model->getCurrency(),
            'CreatedAt' => $this->model->getCreatedAt(),
        ];
    }
}
