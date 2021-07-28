<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Facades\Helpers;

use Helldar\Cashier\Helpers\Date as Helper;
use Illuminate\Support\Carbon;
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
