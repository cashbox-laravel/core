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

namespace CashierProvider\Sber\QrCode\Constants;

class Scopes
{
    public const CREATE = 'https://api.sberbank.ru/order.create';

    public const STATUS = 'https://api.sberbank.ru/order.status';

    public const CANCEL = 'https://api.sberbank.ru/order.cancel';
}
