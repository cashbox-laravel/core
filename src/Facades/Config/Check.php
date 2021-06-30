<?php

namespace Helldar\Cashier\Facades\Config;

use Helldar\Cashier\Helpers\Config\Check as Config;
use Illuminate\Support\Facades\Facade;

/**
 * @method static int delay()
 * @method static int timeout()
 */
class Check extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Config::class;
    }
}
