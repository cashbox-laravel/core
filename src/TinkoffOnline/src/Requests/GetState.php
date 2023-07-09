<?php

/*
 * This file is part of the "cashier-provider/tinkoff-online" project.
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
 * @see https://github.com/cashier-provider/tinkoff-online
 */

declare(strict_types=1);

namespace CashierProvider\Tinkoff\Online\Requests;

class GetState extends BaseRequest
{
    protected $path = '/v2/GetState';

    public function getRawBody(): array
    {
        return [
            'PaymentId' => $this->model->getExternalId(),
        ];
    }
}
