<?php

declare(strict_types=1);

namespace Helldar\Cashier\Facades\Helpers;

use Helldar\Cashier\Helpers\HttpLog as Helper;
use Helldar\Contracts\Cashier\Resources\Model as ModelResource;
use Helldar\Contracts\Http\Builder;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void info(ModelResource $model, string $method, Builder $url, array $request, array $response, int $status_code, ?array $extra = [])
 */
class HttpLog extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
