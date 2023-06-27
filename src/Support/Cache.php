<?php

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
