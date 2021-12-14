<?php

declare(strict_types=1);

namespace CashierProvider\Core\Concerns;

use CashierProvider\Core\Facades\Support\Cache;
use CashierProvider\Core\Jobs\Base;

trait Cacheable
{
    protected function cacheStore(Base $job): void
    {
        Cache::store($job);
    }

    protected function cacheAllow(Base $job): bool
    {
        return Cache::doesntHave($job);
    }
}
