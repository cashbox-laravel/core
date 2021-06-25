<?php

namespace Helldar\Cashier\Facade;

use Helldar\Cashier\Helpers\Access as Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool allow(Model $model)
 */
class Access extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
