<?php

declare(strict_types=1);

namespace Helldar\Cashier\Facades\Config\Payments;

use Helldar\Cashier\Config\Payments\Map as Config;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array getAll()
 * @method static array getTypes()
 * @method static array getNames()
 * @method static string get(string $type)
 */
class Map extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Config::class;
    }
}