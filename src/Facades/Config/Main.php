<?php

namespace Helldar\Cashier\Facades\Config;

use Helldar\Cashier\Helpers\Config\Main as Config;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool hasProduction()
 * @method static string|null logger()
 * @method static string|null queue()
 */
final class Main extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Config::class;
    }
}