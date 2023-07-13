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

namespace CashierProvider\Core\Concerns\Config\Payment;

use CashierProvider\Core\Concerns\Transformers\EnumsTransformer;
use CashierProvider\Core\Data\Config\DriverData;
use CashierProvider\Core\Exceptions\Internal\UnknownDriverConfigException;
use CashierProvider\Core\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait Drivers
{
    use Attributes;
    use EnumsTransformer;

    protected static function drivers(): Collection
    {
        return Config::payment()->drivers;
    }

    protected static function driver(int|string $name, Model $payment): DriverData
    {
        if ($driver = Config::driver($name)) {
            return $driver;
        }

        throw new UnknownDriverConfigException($name, $payment->getKey());
    }

    protected static function driverByModel(Model $payment): DriverData
    {
        $name = $payment->getAttribute(
            static::attribute()->type
        );

        return static::driver(static::transformFromEnum($name), $payment);
    }
}
