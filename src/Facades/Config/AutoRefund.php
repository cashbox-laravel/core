<?php

namespace Helldar\Cashier\Facades\Config;

use Helldar\Cashier\Helpers\Config\AutoRefund as Config;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool has()
 * @method static int delay()
 */
final class AutoRefund extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Config::class;
    }
}
