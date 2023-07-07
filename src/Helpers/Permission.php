<?php

/**
 * This file is part of the "cashier-provider/core" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider
 */

declare(strict_types=1);

namespace CashierProvider\Core\Helpers;

use CashierProvider\Core\Facades\Config;
use Illuminate\Database\Eloquent\Model;

class Permission
{
    public static function allowToStart(Model $payment): bool {}

    public static function allowToVerify(Model $payment): bool {}

    public static function allowToRefund(Model $payment): bool {}

    public static function allowToAutoRefund(): bool
    {
        return Config::refund()->enabled;
    }
}
