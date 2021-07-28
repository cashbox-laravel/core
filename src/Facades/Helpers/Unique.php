<?php

declare(strict_types=1);

namespace Helldar\Cashier\Facades\Helpers;

use Helldar\Cashier\Helpers\Unique as Helper;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string id(bool $unique = true)
 */
class Unique extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
