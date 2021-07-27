<?php

declare(strict_types=1);

namespace Helldar\Cashier\Facades\Config\Payments;

use Helldar\Cashier\Config\Payments\Attributes as Config;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string getType()
 * @method static string getStatus()
 */
class Attributes extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Config::class;
    }
}
