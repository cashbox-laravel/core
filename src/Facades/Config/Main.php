<?php

/*
 * This file is part of the "andrey-helldar/cashier" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/cashier
 */

declare(strict_types=1);

namespace Helldar\Cashier\Facades\Config;

use Helldar\Cashier\Config\Main as Config;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isProduction()
 * @method static string|null getLogger()
 * @method static string|null getQueue()
 * @method static int getCheckDelay()
 * @method static int getCheckTimeout()
 * @method static bool getAutoRefundEnabled()
 * @method static int getAutoRefundDelay()
 * @method static \Helldar\Contracts\Cashier\Config\Driver getDriver(string $name)
 */
class Main extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Config::class;
    }
}
