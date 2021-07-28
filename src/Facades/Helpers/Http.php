<?php

declare(strict_types=1);

namespace Helldar\Cashier\Facades\Helpers;

use Helldar\Cashier\Helpers\Http as Helper;
use Helldar\Contracts\Cashier\Exceptions\ExceptionManager as ExceptionManagerContract;
use Helldar\Contracts\Cashier\Resources\Request;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array post(Request $request, ExceptionManagerContract $manager)
 */
class Http extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
