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

use Cashbox\Core\Concerns\Config\Payment\Drivers;
use Cashbox\Core\Concerns\Helpers\Validatable;
use Cashbox\Core\Data\Config\DriverData;
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
        return resolve($data->driver, compact('payment', 'data'));
    }

    protected static function data(Model $payment): ?DriverData
    {
        return static::driverByModel($payment);
    }
}
