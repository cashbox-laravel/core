<?php

namespace Helldar\Cashier\Facades;

use Helldar\Cashier\Helpers\Unique as Helper;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string uid()
 */
final class Unique extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
