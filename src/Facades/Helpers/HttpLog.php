<?php

declare(strict_types=1);

namespace Helldar\Cashier\Facades\Helpers;

use Helldar\Cashier\Helpers\HttpLog as Helper;
use Helldar\Contracts\Cashier\Resources\Model as ModelResource;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void info(ModelResource $model, string $method, string $url, array $request, array $response, int $status_code)
 */
class HttpLog extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
