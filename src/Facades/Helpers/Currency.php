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

use CashierProvider\Core\Helpers\Currency as Helper;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \CashierProvider\Core\Resources\Currency get(int|string $currency)
 */
class Currency extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
