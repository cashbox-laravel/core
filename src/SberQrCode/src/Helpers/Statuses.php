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

namespace CashierProvider\Sber\QrCode\Helpers;

use CashierProvider\Core\Services\Statuses as BaseStatus;

class Statuses extends BaseStatus
{
    public const NEW = [
        'CREATED',
    ];

    public const REFUNDING = [];

    public const REFUNDED = [
        'REVERSED',
        'REFUNDED',
        'REVOKED',
    ];

    public const FAILED = [];

    public const SUCCESS = [
        'PAID',
    ];
}
