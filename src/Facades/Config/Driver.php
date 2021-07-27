<?php

declare(strict_types=1);

namespace Helldar\Cashier\Facades\Config;

use Helldar\Cashier\Config\Driver as Config;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string getDriver()
 * @method static string getResource()
 * @method static string|null getClientId()
 * @method static string|null getClientSecret()
 */
class Driver extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Config::class;
    }
}
