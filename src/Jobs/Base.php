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

use CashierProvider\Core\Concerns\Attributes;
use CashierProvider\Core\Enums\Status;
use CashierProvider\Core\Exceptions\Logic\EmptyResponseException;
use CashierProvider\Core\Facades\Config;
use CashierProvider\Core\Facades\Model as ModelHelper;
use CashierProvider\Core\Http\Response;
use CashierProvider\Core\Services\Driver;
use CashierProvider\Core\Services\Statuses;
use Closure;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Throwable;

abstract class Base implements ShouldBeUnique, ShouldQueue
{
    use Attributes;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries;

    protected string $event;

    protected bool $doneInsteadThrow = false;

    abstract public function handle(): void;

    abstract protected function process(): Response;

    abstract protected function queueName(): ?string;

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\CashierProvider\Core\Concerns\Casheable  $model
     */
    public function __construct(
        public Model $model,
        public bool $forceBreak = false
    ) {
        $this->afterCommit();
        $this->onQueue($this->queueName());

        $this->tries = Config::queue()->tries;
    }

    public function uniqueId(): string
    {
        return $this->modelId();
    }

    protected function hasBreak(): bool
    {
        return $this->forceBreak;
    }

    protected function store(Response $response, bool $saveDetails = true): void
    {
        if ($response->isEmpty()) {
            $this->fail(new EmptyResponseException(''));
        }

        $external_id  = $response->getExternalId();
        $operation_id = $response->getOperationId();

        $content = $response->toArray();

        if ($saveDetails && $this->model->cashier) {
            $saved = $this->model->cashier->details->toArray();

            $content = array_merge($saved, $content);
        }

        $details = $this->resolveDriver()->details($content);

        ModelHelper::updateOrCreate($this->model, compact('external_id', 'operation_id', 'details'));

        $this->sendEvent();
    }

    protected function sendEvent(): void
    {
        event(new $this->event($this->model));
    }

    protected function modelId(): string
    {
        return $this->model->getKey();
    }

    protected function returnToQueue(): void
    {
        $this->release(
            Config::check()->delay
        );
    }

    protected function updateParentStatus(Status $status): void
    {
        $attribute = $this->attributeStatus();
        $status    = $this->status($status);

        if ($status !== $this->model->cashierStatus()) {
            $this->model->update([
                $attribute => $status,
            ]);
        }
    }

    protected function status(Status $status): mixed
    {
        return Config::payment()->status->get($status);
    }

    protected function hasSuccess(string $status): bool
    {
        return $this->resolveStatuses()->hasSuccess($status);
    }

    protected function hasFailed(string $status): bool
    {
        return $this->resolveStatuses()->hasFailed($status);
    }

    protected function hasRefunding(string $status): bool
    {
        return $this->resolveStatuses()->hasRefunding($status);
    }

    protected function hasRefunded(string $status): bool
    {
        return $this->resolveStatuses()->hasRefunded($status);
    }

    protected function resolveDriver(): Driver
    {
        return $this->model->cashierDriver();
    }

    protected function resolveStatuses(): Statuses
    {
        return $this->resolveDriver()->statuses();
    }

    protected function call(Closure $callback): void
    {
        try {
            $callback();
        }
        catch (Throwable $e) {
            $until = $this->retryUntil();

            if ($this->doneInsteadThrow && $until && $until <= Carbon::now()) {
                return;
            }

            if (
                $this->doneInsteadThrow && ! $until && $this->maxTries() > 0 && $this->attempts() >= $this->maxTries()
            ) {
                return;
            }

            throw $e;
        }
    }

    protected function maxTries(): int
    {
        return $this->job->maxTries() ?? Config::queue()->tries;
    }
}
