<?php

declare(strict_types=1);

namespace CashierProvider\Core\Support;

use CashierProvider\Core\Facades\Config\Main;
use CashierProvider\Core\Jobs\Base;
use DragonCode\Cache\Services\Cache as Service;

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

    protected function instance(Base $job): Service
    {
        return Service::make()
            ->ttl($this->getTtl(), false)
            ->key($job, $job->uniqueId())
            ->tags('cashier');
    }

    protected function getTtl(): int
    {
        return Main::getQueue()->getUnique()->getSeconds();
    }
}
