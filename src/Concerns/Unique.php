<?php

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
