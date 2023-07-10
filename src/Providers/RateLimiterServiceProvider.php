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

use core\src\Concerns\Config\Payment\Attributes;
use core\src\Concerns\Helpers\DateTime;
use CashierProvider\Core\Enums\RateLimiterEnum;
use CashierProvider\Core\Jobs\BaseJob;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\RateLimiter;

class RateLimiterServiceProvider extends BaseProvider
{
    use Attributes;
    use DateTime;

    protected int $attemptsPerHour = 1;

    public function boot(): void
    {
        if ($this->disabled()) {
            return;
        }

        $this->bootDisabledLimit();
        $this->bootEnableLimit();
    }

    protected function bootDisabledLimit(): void
    {
        RateLimiter::for(RateLimiterEnum::disabled(), fn () => Limit::none());
    }

    protected function bootEnableLimit(): void
    {
        RateLimiter::for(RateLimiterEnum::enabled(), function (BaseJob $job) {
            return $this->isToday($job->payment)
                ? Limit::none()
                : Limit::perHour($this->attemptsPerHour)->by($job->payment->getKey());
        });
    }

    protected function isToday(Model $payment): bool
    {
        $date = $payment->getAttribute(
            static::attribute()->createdAt
        );

        return static::carbon($date)->isToday();
    }
}
