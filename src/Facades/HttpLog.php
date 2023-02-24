<?php

declare(strict_types=1);

namespace CashierProvider\Core\Facades;

use CashierProvider\Core\Helpers\HttpLog as Helper;
use CashierProvider\Core\Resources\Model;
use DragonCode\Support\Http\Builder;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void info(Model $model, string $method, Builder $url, array $request, array $response, int $status_code, ?array $extra = [])
 */
class HttpLog extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Helper::class;
    }
}
