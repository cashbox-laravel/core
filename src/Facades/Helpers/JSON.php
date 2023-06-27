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

use CashierProvider\Core\Helpers\JSON as Helper;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array decode(?string $encoded)
 * @method static string encode(mixed $value)
 */
class JSON extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
