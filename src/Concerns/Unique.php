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

namespace CashierProvider\Core\Concerns;

use CashierProvider\Core\Facades\Support\Cache;
use CashierProvider\Core\Jobs\Base;

trait Unique
{
    protected function uniqueStore(Base $job): void
    {
        Cache::store($job);
    }

    protected function uniqueAllow(Base $job): bool
    {
        return Cache::doesntHave($job);
    }
}
