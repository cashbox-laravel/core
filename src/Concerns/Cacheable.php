<?php

declare(strict_types=1);

namespace CashierProvider\Core\Concerns;

use CashierProvider\Core\Facades\Support\Cache;
use CashierProvider\Core\Jobs\Base;

trait Cacheable
{
    protected function cachePut(Base $job): void
    {
        Cache::put($job);
    }

    protected function cacheHasUnique(Base $job): bool
    {
        return Cache::isUnique($job);
    }
}
