<?php

declare(strict_types=1);

namespace CashierProvider\BankName\Technology\Requests;

class Cancel extends BaseRequest
{
    protected $path = '/api/cancel';

    protected $reload_relations = true;

    public function getRawBody(): array
    {
        return [
            'PaymentId' => $this->model->getExternalId(),

            'Amount' => $this->model->getSum(),
        ];
    }
}
