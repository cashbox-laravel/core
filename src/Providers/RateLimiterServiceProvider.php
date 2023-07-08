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

namespace CashierProvider\Core\Providers;

use CashierProvider\Core\Concerns\Config\Payment\Attributes;
use CashierProvider\Core\Enums\RateLimiterEnum;
use CashierProvider\Core\Jobs\BaseJob;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\RateLimiter;

class RateLimiterServiceProvider extends BaseProvider
{
    use Attributes;

    public function boot(): void
    {
        if ($this->disabled()) {
            return;
        }

        $this->bootVerifyLimit();
    }

    protected function bootVerifyLimit(): void
    {
        RateLimiter::for(RateLimiterEnum::hourly(), function (BaseJob $job) {
            return $this->isToday($job->payment)
                ? Limit::none()
                : Limit::perHour(1)->by($job->payment->getKey());
        });
    }

    protected function isToday(Model $payment): bool
    {
        return $payment->getAttribute(
            static::attribute()->createdAt
        )->isToday();
    }
}
