<?php

declare(strict_types=1);

namespace CashierProvider\Tinkoff\Credit\Requests;

class Init extends BaseRequest
{
    protected $path = '/api/partners/v2/orders/create';

    protected $path_dev = '/api/partners/v2/orders/create-demo';

    protected $hash = false;

    public function getRawBody(): array
    {
        return [
            'shopId'     => $this->model->getClientId(),
            'showcaseId' => $this->model->getShowCaseId(),
            'promoCode'  => $this->model->getPromoCode(),

            'sum' => $this->model->getSum(),

            'orderNumber' => $this->model->getPaymentId(),

            'values' => [
                'contact' => [
                    'fio' => [
                        'lastName'   => $this->model->getClient()->last_name,
                        'firstName'  => $this->model->getClient()->first_name,
                        'middleName' => $this->model->getClient()->middle_name,
                    ],

                    'mobilePhone' => $this->model->getClient()->phone,
                    'email'       => $this->model->getClient()->email,
                ],
            ],

            'items' => $this->model->getItems()->toArray(),
        ];
    }

    protected function getPath(): ?string
    {
        return $this->getUri();
    }
}
