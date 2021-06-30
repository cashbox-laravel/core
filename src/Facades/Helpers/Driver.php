<?php

namespace Helldar\Cashier\Facades\Helpers;

use Helldar\Cashier\Contracts\Driver as Contract;
use Helldar\Cashier\Helpers\Driver as Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Contract fromModel(Model $model)
 */
class Driver extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
