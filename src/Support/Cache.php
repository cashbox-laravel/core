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

namespace CashierProvider\Core\Support;

use CashierProvider\Core\Jobs\Base;
use DragonCode\Cache\Services\Cache as DragonCache;

class Cache
{
    public function store(Base $job): void
    {
        $this->instance($job)->put($job->uniqueId());
    }

    public function doesntHave(Base $job): bool
    {
        return $this->instance($job)->doesntHave();
    }

    protected function instance(Base $job): DragonCache
    {
        return DragonCache::make()
            ->ttl($job->uniqueFor(), false)
            ->key($job, $job->uniqueId());
    }
}
