<?php

namespace Helldar\Cashier\Services;

use Helldar\Cashier\Contracts\Driver as DriverContract;
use Helldar\Cashier\Contracts\Statuses;
use Helldar\Cashier\Facades\Access;
use Helldar\Cashier\Facades\Config\AutoRefund;
use Helldar\Cashier\Facades\Config\Main;
use Helldar\Cashier\Facades\Helpers\Driver as DriverHelper;
use Helldar\Cashier\Jobs\Check;
use Helldar\Cashier\Jobs\Init;
use Helldar\Cashier\Jobs\Refund;
use Helldar\Support\Concerns\Makeable;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Jobs make(Model $model)
 */
final class Jobs
{
    use Makeable;

    /** @var \Illuminate\Database\Eloquent\Model */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function init()
    {
        if ($this->hasInit($this->model)) {
            $this->retry();
        }
    }

    public function retry()
    {
        $this->send(Init::class);

        if ($this->hasAutoRefund()) {
            $delay = $this->autoRefundDelay();

            $this->refund($delay);
        }
    }

    public function check(bool $force_break = false)
    {
        if ($this->hasCheck($this->model)) {
            $this->send(Check::class, $force_break);
        }
    }

    public function refund(int $delay = null): void
    {
        $this->send(Refund::class, false, $delay);
    }

    protected function send($job, bool $force_break = false, int $delay = null): void
    {
        /** @var \Helldar\Cashier\Jobs\Base $instance */
        $instance = new $job($this->model, $force_break);

        $queue = $this->onQueue();

        $instance->delay($delay);

        dispatch($instance)->onQueue($queue);
    }

    protected function hasInit(Model $model): bool
    {
        if (! $this->hasType($model)) {
            return false;
        }

        if (! $this->status($model)->hasCreated()) {
            return false;
        }

        if ($this->hasRequested($model)) {
            return false;
        }

        return true;
    }

    protected function hasCheck(Model $model): bool
    {
        if (! $this->hasType($model)) {
            return false;
        }

        if (! $this->status($model)->inProgress()) {
            return false;
        }

        return true;
    }

    protected function hasType(Model $model): bool
    {
        return Access::allow($model);
    }

    protected function hasRequested(Model $model): bool
    {
        return $model->details()->exists();
    }

    protected function hasAutoRefund(): bool
    {
        return AutoRefund::has();
    }

    protected function autoRefundDelay(): int
    {
        return AutoRefund::delay();
    }

    protected function onQueue(): ?string
    {
        return Main::queue();
    }

    protected function driver(Model $model): DriverContract
    {
        return DriverHelper::fromModel($model);
    }

    protected function status(Model $model): Statuses
    {
        return $this->driver($model)->statuses();
    }
}
