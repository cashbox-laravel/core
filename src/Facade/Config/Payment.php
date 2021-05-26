<?php

namespace Helldar\Cashier\Facade\Config;

use Helldar\Cashier\Helpers\Config\Payment as Config;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string model()
 * @method static string attributeType()
 * @method static string attributeStatus()
 * @method static string attributeSum()
 * @method static array statuses()
 * @method static array assignDrivers()
 */
final class Payment extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Config::class;
    }
}
