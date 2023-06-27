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

namespace CashierProvider\Core\Facades\Support;

use CashierProvider\Core\Jobs\Base;
use CashierProvider\Core\Support\Cache as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool doesntHave(Base $job)
 * @method static void store(Base $job)
 */
class Cache extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Support::class;
    }
}
