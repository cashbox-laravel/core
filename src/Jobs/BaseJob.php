<?php

/**
 * This file is part of the "cashbox/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://cashbox.city
 */

declare(strict_types=1);

namespace Cashbox\Core\Jobs;

use Cashbox\Core\Billable;
use Cashbox\Core\Concerns\Config\Queue;
use Cashbox\Core\Data\Models\InfoData;
use Cashbox\Core\Enums\RateLimiterEnum;
use Cashbox\Core\Exceptions\External\EmptyResponseHttpException;
use Cashbox\Core\Http\Response;
use Cashbox\Core\Services\Driver;
use Cashbox\Core\Support\Arr;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimitedWithRedis;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
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

    abstract protected function request(): Response;

    public function __construct(
        public Model $payment,
        public bool $force = false
    ) {
        $this->tries         = static::queueConfig()->tries;
        $this->maxExceptions = static::queueConfig()->exceptions;
    }

    public function handle(): void
    {
        $response = $this->request();

        if ($response->isEmpty()) {
            $this->fail(new EmptyResponseHttpException());

            return;
        }

        $this->update($this->prepareData($response));
        $this->finish();
    }

    public function uniqueId(): int|string
    {
        return $this->payment->getKey() . $this->generateUniqueId();
    }

    public function middleware(): array
    {
        return [new RateLimitedWithRedis($this->getRateLimiter())];
    }

    protected function prepareData(Response $response): array
    {
        return [
            'external_id'  => $response->getExternalId(),
            'operation_id' => $response->getOperationId(),
            'info'         => $this->mergeInfo($response->getInfo()),
        ];
    }

    protected function mergeInfo(InfoData $data): InfoData
    {
        $stored = $this->payment->cashbox()->first()?->info?->extra ?? [];

        return InfoData::from([
            'externalId'  => $data->externalId,
            'operationId' => $data->operationId,
            'status'      => $data->status,
            'extra'       => Arr::merge($stored, $data->extra),
        ]);
    }

    protected function update(array $data): void
    {
        if ($this->payment->cashbox()->exists()) {
            $this->payment->refresh();
            $this->payment->cashbox->update($data);

            return;
        }

        $this->payment->cashbox()->create($data);
    }

    protected function finish(): void {}

    protected function driver(): Driver
    {
        return $this->payment->cashboxDriver();
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

            return retry(2, fn () => Str::random());
        }
        catch (Throwable) {
            return '_' . (int) $this->force;
        }
    }
}
