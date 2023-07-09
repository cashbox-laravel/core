<?php

/*
 * This file is part of the "cashier-provider/sber-qr" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/cashier-provider/sber-qr
 */

declare(strict_types=1);

namespace CashierProvider\Sber\QrCode\Requests;

use CashierProvider\Sber\QrCode\Constants\Body;
use CashierProvider\Sber\QrCode\Constants\Scopes;

class Create extends BaseRequest
{
    protected $path = '/ru/prod/order/v1/creation';

    protected $auth_extra = [
        Body::SCOPE => Scopes::CREATE,
    ];

    public function getRawBody(): array
    {
        return [
            Body::REQUEST_ID   => $this->uniqueId(),
            Body::REQUEST_TIME => $this->currentTime(),

            Body::MEMBER_ID   => $this->model->getMemberId(),
            Body::TERMINAL_ID => $this->model->getTerminalId(),

            Body::ORDER_ID         => $this->model->getPaymentId(),
            Body::ORDER_SUM        => $this->model->getSum(),
            Body::ORDER_CURRENCY   => $this->model->getCurrency(),
            Body::ORDER_CREATED_AT => $this->model->getCreatedAt(),
        ];
    }
}
