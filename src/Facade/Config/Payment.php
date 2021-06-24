<?php

namespace Helldar\Cashier\Facade\Config;

use Helldar\Cashier\Helpers\Config\Payment as Config;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array assignDrivers()
 * @method static array attributes()
 * @method static array statuses()
 * @method static mixed status(string $status)
 * @method static string attributeStatus()
 * @method static string attributeSum()
 * @method static string attributeType()
 * @method static string model()
 */
final class Payment extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Config::class;
    }
}
