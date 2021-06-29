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
use Illuminate\Database\Eloquent\Model;

final class Jobs
{
    public function init(Model $model)
    {
        if ($this->hasInit($model)) {
            $this->retry($model);
        }
    }

    public function retry(Model $model)
    {
        $this->send($model, Init::class);

        if ($this->hasAutoRefund()) {
            $delay = $this->autoRefundDelay();

            $this->refund($model, $delay);
        }
    }

    public function check(Model $model, bool $force_break = false)
    {
        if ($this->hasCheck($model)) {
            $this->send($model, Check::class, $force_break);
        }
    }

    public function refund(Model $model, int $delay = null): void
    {
        $this->send($model, Refund::class, false, $delay);
    }

    protected function send(Model $model, $job, bool $force_break = false, int $delay = null): void
    {
        /** @var \Helldar\Cashier\Jobs\Base $instance */
        $instance = new $job($model, $force_break);

        $queue = $this->onQueue();

        $instance->delay($delay);

        dispatch($instance)->onQueue($queue);
    }

    protected function hasInit(Model $model): bool
    {
        if (! $this->hasType($model)) {
            return false;
        }

        if (! $this->status($model)->hasCreated($model)) {
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

        if (! $this->status($model)->inProgress($model)) {
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
