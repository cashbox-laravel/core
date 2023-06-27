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

use CashierProvider\Core\Config\Main as Config;
use DragonCode\Contracts\Cashier\Config\Driver;
use DragonCode\Contracts\Cashier\Config\Queue;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isProduction()
 * @method static string|null getLogger()
 * @method static Queue getQueue()
 * @method static int getCheckDelay()
 * @method static int getCheckTimeout()
 * @method static bool getAutoRefundEnabled()
 * @method static int getAutoRefundDelay()
 * @method static Driver getDriver(string $name)
 */
class Main extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Config::class;
    }
}
