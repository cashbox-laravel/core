<?php

declare(strict_types=1);

namespace Helldar\Cashier\Facades\Helpers;

use Helldar\Cashier\Helpers\Model as Helper;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool exists(EloquentModel $model)
 * @method static void create(EloquentModel $payment, array $data)
 * @method static void update(EloquentModel $payment, array $data)
 * @method static void updateOrCreate(EloquentModel $payment, array $data)
 */
class Model extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
