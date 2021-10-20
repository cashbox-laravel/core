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

namespace CashierProvider\Core\Facades\Helpers;

use CashierProvider\Core\Helpers\Model as Helper;
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
