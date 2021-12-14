<?php

declare(strict_types=1);

namespace CashierProvider\Core\Support;

use CashierProvider\Core\Jobs\Base;
use DragonCode\Cache\Services\Cache as Service;

class Cache
{
    public function put(Base $job): void
    {
        $this->instance($job)->put($job->uniqueId());
    }

    public function isUnique(Base $job): bool
    {
        return $this->instance($job)->doesntHave();
    }

    protected function instance(Base $job): Service
    {
        return Service::make()
            ->ttl($job->uniqueFor)
            ->key(self::class, get_class($job), $job->uniqueId());
    }
}
