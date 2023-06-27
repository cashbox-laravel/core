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

namespace CashierProvider\Core\Facades\Helpers;

use CashierProvider\Core\Helpers\Unique as Helper;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string id(bool $unique = true)
 * @method static string uuid(bool $unique = true)
 */
class Unique extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
