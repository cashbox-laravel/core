<?php

declare(strict_types=1);

namespace CashierProvider\BankName\Technology\Requests;

class Init extends BaseRequest
{
    protected $path = '/api/create';

    protected $hash = false;

    protected $auth_extra = [
        'scope' => 'scope-if-needed',
    ];

    public function getRawBody(): array
    {
        return [
            'OrderId' => $this->model->getPaymentId(),

            'Amount' => $this->model->getSum(),

            'Currency' => $this->model->getCurrency(),
        ];
    }
}
