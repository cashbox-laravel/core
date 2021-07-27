<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Facades\Config;

use Helldar\Cashier\Config\Details as Config;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string getTable()
 */
class Details extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Config::class;
    }
}
