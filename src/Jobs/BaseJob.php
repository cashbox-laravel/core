<?php

/**
 * This file is part of the "cashier-provider/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider/foundation
 */

declare(strict_types=1);

namespace CashierProvider\Core\Jobs;

use CashierProvider\Core\Billable;
use CashierProvider\Core\Concerns\Config\Queue;
use CashierProvider\Core\Enums\RateLimiterEnum;
use CashierProvider\Core\Exceptions\External\EmptyResponseException;
use CashierProvider\Core\Http\ResponseInfo;
use CashierProvider\Core\Services\Driver;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimitedWithRedis;
use Illuminate\Queue\SerializesModels;
use Throwable;

/**
 * @property Model|Billable $payment
 */
abstract class BaseJob implements ShouldBeUnique, ShouldQueue
{
    use InteractsWithQueue;
    use Queue;
    use Queueable;
    use SerializesModels;

    public int $tries = 10;

    public int $maxExceptions = 3;

    abstract protected function request(): ResponseInfo;

    public function __construct(
        public Model $payment,
        public bool $force = false
    ) {
        $this->tries         = static::queue()->tries;
        $this->maxExceptions = static::queue()->exceptions;
    }

    public function handle(): void
    {
        $response = $this->request();

        if ($response->isEmpty()) {
            $this->fail(new EmptyResponseException());

            return;
        }

        $data = [
            'external_id'  => $response->getExternalId(),
            'operation_id' => $response->getOperationId(),
            'info'         => $response,
        ];

        $this->payment->cashier
            ? $this->payment->cashier->update($data)
            : $this->payment->cashier()->create($data);
    }

    public function uniqueId(): int|string
    {
        return $this->payment->getKey() . $this->generateUniqueId();
    }

    public function middleware(): array
    {
        return [new RateLimitedWithRedis($this->getRateLimiter())];
    }

    protected function driver(): Driver
    {
        return $this->payment->cashierDriver();
    }

    protected function getRateLimiter(): string
    {
        return $this->force ? RateLimiterEnum::disabled() : RateLimiterEnum::enabled();
    }

    protected function generateUniqueId(): string
    {
        try {
            if (! $this->force) {
                return '';
            }

            return retry(2, fn () => '_' . random_bytes(10));
        }
        catch (Throwable) {
            return '_' . (int) $this->force;
        }
    }
}
