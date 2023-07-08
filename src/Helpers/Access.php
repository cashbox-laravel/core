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

use CashierProvider\Core\Data\Config\Payment\AttributeData;
use CashierProvider\Core\Facades\Config;
use Illuminate\Database\Eloquent\Model;

class Access
{
    /**
     * @param  \Illuminate\Database\Eloquent\Model|\CashierProvider\Core\Concerns\Casheable  $payment
     *
     * @return bool
     */
    public static function toStart(Model $payment): bool
    {
        return static::allowType($payment)
            && $payment->cashierDriver()->statuses()->hasCreated();
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\CashierProvider\Core\Concerns\Casheable  $payment
     *
     * @return bool
     */
    public static function toVerify(Model $payment): bool
    {
        return static::allowType($payment)
            && $payment->cashierDriver()->statuses()->inProgress();
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\CashierProvider\Core\Concerns\Casheable  $payment
     *
     * @return bool
     */
    public static function toRefund(Model $payment): bool
    {
        return static::allowType($payment)
            && $payment->cashierDriver()->statuses()->inProgress();
    }

    protected static function allowType(Model $payment): bool
    {
        return in_array(static::paymentType($payment), static::paymentTypes(), true);
    }

    protected static function paymentTypes(): array
    {
        return Config::payment()->drivers->keys()->toArray();
    }

    protected static function paymentType(Model $payment): mixed
    {
        return $payment->getAttribute(static::attribute()->type);
    }

    protected static function attribute(): AttributeData
    {
        return Config::payment()->attribute;
    }
}
