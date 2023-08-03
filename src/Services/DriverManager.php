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
 * @see https://cashbox.city
 */

declare(strict_types=1);

namespace Cashbox\Core\Services;

use Cashbox\Core\Concerns\Config\Payment\Drivers;
use Cashbox\Core\Concerns\Helpers\Validatable;
use Cashbox\Core\Concerns\Repositories\Registry;
use Cashbox\Core\Data\Config\DriverData;
use Illuminate\Database\Eloquent\Model;

class DriverManager
{
    use Drivers;
    use Registry;
    use Validatable;

    public static function find(Model $payment): Driver
    {
        return static::call(static::data($payment), $payment);
    }

    protected static function call(DriverData $data, Model $payment): Driver
    {
        $driver = $data->driver;

        return new $driver($payment, $data);
    }

    protected static function data(Model $payment): ?DriverData
    {
        return static::driverByModel($payment);
    }
}
