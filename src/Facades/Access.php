<?php

/**
 * This file is part of the "cashier-provider/core" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider
 */

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
