<?php

/*
 * This file is part of the "cashier-provider/core" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/cashier-provider/core
 */

declare(strict_types=1);

namespace CashierProvider\Core\Jobs;

use CashierProvider\Core\Concerns\Driverable;
use CashierProvider\Core\Concerns\Relations;
use CashierProvider\Core\Exceptions\Logic\EmptyResponseException;
use CashierProvider\Core\Facades\Config\Main;
use CashierProvider\Core\Facades\Config\Payment;
use CashierProvider\Core\Facades\Helpers\Model as ModelHelper;
use Helldar\Contracts\Cashier\Driver;
use Helldar\Contracts\Cashier\Helpers\Statuses;
use Helldar\Contracts\Cashier\Http\Response;
use Helldar\Support\Concerns\Makeable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

abstract class Base implements ShouldQueue, ShouldBeUnique
{
    use Driverable;
    use InteractsWithQueue;
    use Makeable;
    use Queueable;
    use Relations;
    use SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries;

    /** @var \CashierProvider\Core\Concerns\Casheable|\Illuminate\Database\Eloquent\Model */
    public $model;

    public $force_break;

    public $uniqueFor;

    protected $event;

    public function __construct(Model $model, bool $force_break = false)
    {
        $this->model = $model;

        $this->force_break = $force_break;

        $this->afterCommit = Main::getQueue()->afterCommit();

        $this->tries = Main::getQueue()->getTries();

        $this->uniqueFor = Main::getQueue()->getUnique()->getSeconds();

        $this->queue = $this->queueName();
    }

    abstract public function handle();

    public function uniqueId()
    {
        return $this->model->getKey();
    }

    public function uniqueVia()
    {
        $driver = Main::getQueue()->getUnique()->getDriver();

        return Cache::driver($driver);
    }

    public function retryUntil(): Carbon
    {
        $timeout = Main::getCheckTimeout();

        return Carbon::now()->addSeconds($timeout);
    }

    abstract protected function process(): Response;

    abstract protected function queueName(): ?string;

    protected function hasBreak(): bool
    {
        return $this->force_break;
    }

    protected function store(Response $response, bool $save_details = true): void
    {
        if ($response->isEmpty()) {
            $this->fail(
                new EmptyResponseException('')
            );
        }

        $external_id  = $response->getExternalId();
        $operation_id = $response->getOperationId();

        $content = $response->toArray();

        $this->resolveCashier($this->model);

        if ($save_details && ! empty($this->model->cashier)) {
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
        $delay = Main::getCheckDelay();

        $this->release($delay);
    }

    protected function updateParentStatus(string $status): void
    {
        $attribute = $this->attributeStatus();
        $status    = $this->status($status);

        if ($this->model->getAttribute($attribute) !== $status) {
            $this->model->update([
                $attribute => $status,
            ]);
        }
    }

    protected function attributeStatus(): string
    {
        return Payment::getAttributes()->getStatus();
    }

    protected function status(string $status)
    {
        return Payment::getStatuses()->getStatus($status);
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
        return $this->driver($this->model);
    }

    protected function resolveStatuses(): Statuses
    {
        return $this->resolveDriver()->statuses();
    }
}