<?php

namespace Helldar\Cashier\Facades\Helpers;

use Helldar\Cashier\Helpers\Http as Helper;
use Illuminate\Support\Facades\Facade;
use Psr\Http\Message\UriInterface;

/**
 * @method static array post(UriInterface $uri, array $data, array $headers)
 */
class Http extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
