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

namespace CashierProvider\Core\Jobs;

use CashierProvider\Core\Enums\RateLimiterEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimitedWithRedis;
use Illuminate\Queue\SerializesModels;

abstract class BaseJob implements ShouldQueue, ShouldBeUnique
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    abstract public function handle(): void;

    public function __construct(
        public Model $payment,
        public bool $force = false
    ) {}

    public function uniqueId(): int
    {
        return $this->payment->getKey();
    }

    public function middleware(): array
    {
        return [new RateLimitedWithRedis($this->getRateLimiter())];
    }

    protected function getRateLimiter(): string
    {
        return $this->force ? RateLimiterEnum::disabled() : RateLimiterEnum::hourly();
    }
}
