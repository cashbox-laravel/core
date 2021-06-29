<?php

namespace Helldar\Cashier\Facades\Helpers;

use Helldar\Cashier\Helpers\Http as Helper;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array post(string $uri, array $data, array $headers)
 */
final class Http extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
