<?php

/**
 * This file is part of the "cashier-provider/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider/foundation
 */

declare(strict_types=1);

namespace CashierProvider\Core\Services;

use CashierProvider\Core\Concerns\Config\Payment\Attributes;
use CashierProvider\Core\Concerns\Config\Payment\Statuses;
use CashierProvider\Core\Facades\Config;
use Illuminate\Database\Eloquent\Model;

class Authorize
{
    use Attributes;
    use Statuses;

    public static function toStart(Model $payment): bool
    {
        return static::acceptType($payment)
            && static::acceptStatus($payment, static::statuses()->new)
            && static::doesntHaveDetails($payment);
    }

    public static function toVerify(Model $payment): bool
    {
        return static::acceptType($payment)
            && static::acceptStatus($payment, static::statuses()->inProgress())
            && static::hasDetails($payment);
    }

    public static function toRefund(Model $payment): bool
    {
        return static::acceptType($payment)
            && static::acceptStatus($payment, static::statuses()->toRefund())
            && static::hasDetails($payment);
    }

    protected static function acceptType(Model $payment): bool
    {
        return in_array(static::paymentType($payment), static::paymentTypes(), true);
    }

    protected static function acceptStatus(Model $payment, array|int|string $statuses): bool
    {
        return in_array(static::paymentStatus($payment), (array) $statuses, true);
    }

    protected static function hasDetails(Model $payment): bool
    {
        return ! empty($payment->cashier);
    }

    protected static function doesntHaveDetails(Model $payment): bool
    {
        return ! static::hasDetails($payment);
    }

    protected static function paymentTypes(): array
    {
        return Config::payment()->drivers->keys()->toArray();
    }

    protected static function paymentType(Model $payment): mixed
    {
        return $payment->getAttribute(static::attribute()->type);
    }

    protected static function paymentStatus(Model $payment): mixed
    {
        return $payment->getAttribute(static::attribute()->status);
    }
}
