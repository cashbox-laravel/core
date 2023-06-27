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

namespace CashierProvider\Core\Facades\Config;

use CashierProvider\Core\Config\Logs as Config;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isEnabled()
 * @method static string getTable()
 * @method static string|null getConnection()
 */
class Logs extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Config::class;
    }
}
