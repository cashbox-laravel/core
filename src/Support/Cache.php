<?php

declare(strict_types=1);

namespace CashierProvider\Core\Support;

use CashierProvider\Core\Facades\Config\Main;
use CashierProvider\Core\Jobs\Base;
use DragonCode\Cache\Services\Cache as Service;

class Cache
{
    public function hasUniqueJob(Base $job): bool
    {
        return $this->instance(get_class($job), $job->uniqueId())->doesntHave();
    }

    protected function instance(string $job, string $id): Service
    {
        return Service::make()
            ->ttl($this->ttl())
            ->key(self::class, $job, $id);
    }

    protected function ttl(): int
    {
        return Main::getQueue()->getUnique()->getSeconds();
    }
}
