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

namespace Cashbox\Core\Concerns\Config\Payment;

use Cashbox\Core\Data\Config\DriverData;
use Cashbox\Core\Exceptions\Internal\UnknownDriverConfigException;
use Cashbox\Core\Facades\Config;
use Illuminate\Database\Eloquent\Model;

trait Drivers
{
    protected static function driver(int|string $name, Model $payment): DriverData
    {
        if ($driver = Config::driver($name)) {
            return $driver;
        }

        throw new UnknownDriverConfigException($name, $payment->getKey());
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\Cashbox\Core\Billable  $payment
     *
     * @throws \Cashbox\Core\Exceptions\Internal\UnknownDriverConfigException
     *
     * @return \Cashbox\Core\Data\Config\DriverData
     */
    protected static function driverByModel(Model $payment): DriverData
    {
        return static::driver($payment->cashboxAttributeType(), $payment);
    }
}
