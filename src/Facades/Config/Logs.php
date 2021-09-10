<?php

declare(strict_types=1);

namespace Helldar\Cashier\Facades\Config;

use Helldar\Cashier\Config\Logs as Config;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isEnabled()
 * @method static string getTable()
 * @method static string|null getConnection()
 */
class Logs extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Config::class;
    }
}
