<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Facades\Helpers;

use Helldar\Cashier\Helpers\DriverManager as Helper;
use Helldar\Contracts\Cashier\Driver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Driver fromModel(Model $model)
 */
class DriverManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
