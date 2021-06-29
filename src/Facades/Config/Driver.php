<?php

namespace Helldar\Cashier\Facades\Config;

use Helldar\Cashier\Helpers\Config\Driver as Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Helldar\Cashier\Contracts\Driver get(string $type_id, Model $auth)
 */
final class Driver extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Config::class;
    }
}
