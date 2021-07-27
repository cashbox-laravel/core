<?php

declare(strict_types=1);

namespace Helldar\Cashier\Facades\Helpers;

use Helldar\Cashier\Helpers\JSON as Helper;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array decode(string $encoded)
 * @method static string encode(mixed $value)
 */
class JSON extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
