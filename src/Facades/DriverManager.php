<?php

declare(strict_types=1);

namespace CashierProvider\Core\Facades;

use CashierProvider\Core\Helpers\DriverManager as Helper;
use CashierProvider\Core\Services\Driver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Driver fromModel(Model $model)
 */
class DriverManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Helper::class;
    }
}
