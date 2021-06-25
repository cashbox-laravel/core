<?php

namespace Helldar\Cashier\Facade\Config;

use Helldar\Cashier\Contracts\Auth;
use Helldar\Cashier\Helpers\Config\Driver as Config;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Helldar\Cashier\Contracts\Driver get(string $type_id, Auth $auth)
 */
final class Driver extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Config::class;
    }
}
