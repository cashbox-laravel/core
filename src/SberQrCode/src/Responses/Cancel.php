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

namespace CashierProvider\Sber\QrCode\Responses;

use CashierProvider\Core\Http\Response;

class Cancel extends Response
{
    protected $map = [
        self::KEY_EXTERNAL_ID => 'status.order_id',

        self::KEY_OPERATION_ID => 'status.order_operation_params.0.operation_id',

        self::KEY_STATUS => 'status.order_status',
    ];

    public function isEmpty(): bool
    {
        return empty($this->getExternalId()) || empty($this->getOperationId());
    }
}
