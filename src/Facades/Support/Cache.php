<?php

declare(strict_types=1);

namespace CashierProvider\Core\Facades\Support;

use CashierProvider\Core\Jobs\Base;
use CashierProvider\Core\Support\Cache as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool hasUniqueJob(Base $job)
 */
class Cache extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Support::class;
    }
}
