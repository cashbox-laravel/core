<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Facades\Config;

use Helldar\Cashier\Config\Payment as Config;
use Helldar\Contracts\Cashier\Config\Payments\Attributes;
use Helldar\Contracts\Cashier\Config\Payments\Map;
use Helldar\Contracts\Cashier\Config\Payments\Statuses;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string getModel()
 * @method static Attributes getAttributes()
 * @method static Statuses getStatuses()
 * @method static Map getMap()
 */
class Payment extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Config::class;
    }
}
