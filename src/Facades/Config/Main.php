<?php

declare(strict_types = 1);

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
