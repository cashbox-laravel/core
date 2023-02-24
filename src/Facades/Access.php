<?php

declare(strict_types=1);

namespace CashierProvider\Core\Facades;

use CashierProvider\Core\Helpers\Access as Helper;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool allow(EloquentModel $model)
 */
class Access extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Helper::class;
    }
}
