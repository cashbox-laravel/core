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

namespace CashierProvider\Core\Services;

use core\src\Concerns\Config\Payment\Drivers;
use CashierProvider\Core\Concerns\Helpers\Validatable;
use core\src\Data\Config\DriverData;
use Illuminate\Database\Eloquent\Model;

class DriverManager
{
    use Drivers;
    use Validatable;

    public static function find(Model $payment): Driver
    {
        static::validateModel($payment);

        return static::call(static::data($payment), $payment);
    }

    protected static function call(DriverData $data, Model $payment): Driver
    {
        return call_user_func([$data->driver, 'make'], $data, $payment);
    }

    protected static function data(Model $payment): ?DriverData
    {
        return static::driverByModel($payment);
    }
}
