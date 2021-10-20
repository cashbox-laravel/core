<?php

/*
 * This file is part of the "andrey-helldar/cashier" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/cashier
 */

declare(strict_types=1);

namespace CashierProvider\Manager\Facades\Helpers;

use CashierProvider\Manager\Helpers\HttpLog as Helper;
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
