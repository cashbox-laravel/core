<?php

namespace Helldar\Cashier\Facades;

use Carbon\Carbon;
use Helldar\Cashier\Helpers\Date as Helper;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string toString(Carbon $date)
 */
class Date extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
