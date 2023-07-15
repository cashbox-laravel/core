<?php

/**
 * This file is part of the "cashbox/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashbox-laravel/foundation
 */

declare(strict_types=1);

namespace Cashbox\Core\Services;

use Cashbox\Core\Concerns\Config\Payment\Statuses;
use Cashbox\Core\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Authorize
{
    use Statuses;

    public static function type(Model $payment): bool
    {
        return static::acceptType($payment);
    }

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

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\Cashbox\Core\Billable  $payment
     *
     * @return bool
     */
    protected static function acceptType(Model $payment): bool
    {
        return in_array($payment->cashboxAttributeType(), static::paymentTypes(), true);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\Cashbox\Core\Billable  $payment
     * @param  mixed  $statuses
     *
     * @return bool
     */
    protected static function acceptStatus(Model $payment, mixed $statuses): bool
    {
        return in_array($payment->cashboxAttributeStatus(), Arr::wrap($statuses), true);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\Cashbox\Core\Billable  $payment
     *
     * @return bool
     */
    protected static function hasDetails(Model $payment): bool
    {
        return ! empty($payment->cashbox);
    }

    protected static function doesntHaveDetails(Model $payment): bool
    {
        return ! static::hasDetails($payment);
    }

    protected static function paymentTypes(): array
    {
        return Config::payment()->drivers;
    }
}
