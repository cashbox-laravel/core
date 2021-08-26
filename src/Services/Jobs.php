<?php

/*
 * This file is part of the "andrey-helldar/cashier" project.
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
 * @see https://github.com/andrey-helldar/cashier
 */

declare(strict_types=1);

namespace Helldar\Cashier\Services;

use Helldar\Cashier\Facades\Config\Main;
use Helldar\Cashier\Facades\Helpers\Access;
use Helldar\Cashier\Facades\Helpers\DriverManager;
use Helldar\Cashier\Jobs\Check;
use Helldar\Cashier\Jobs\Refund;
use Helldar\Cashier\Jobs\Start;
use Helldar\Contracts\Cashier\Driver as DriverContract;
use Helldar\Contracts\Cashier\Helpers\Statuses;
use Helldar\Support\Concerns\Makeable;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Jobs make(Model $model)
 */
class Jobs
{
    use Makeable;

    /** @var \Illuminate\Database\Eloquent\Model */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function start()
    {
        if ($this->hasStart($this->model)) {
            $this->retry();
        }
    }

    public function retry()
    {
        $this->send(Start::class);

        if ($this->hasAutoRefund()) {
            $delay = $this->autoRefundDelay();

            $this->refund($delay);
        }
    }

    public function check(bool $force = false, int $delay = null)
    {
        if ($this->hasCheck($this->model) || $force) {
            $this->send(Check::class, $force, $delay);
        }
    }

    public function refund(int $delay = null): void
    {
        $this->send(Refund::class, false, $delay);
    }

    /**
     * @param  \Helldar\Cashier\Jobs\Base|string  $job
     * @param  bool  $force_break
     * @param  int|null  $delay
     */
    protected function send($job, bool $force_break = false, int $delay = null): void
    {
        $instance = $job::make($this->model, $force_break);

        $instance->delay($delay);

        dispatch($instance)->onConnection($this->onConnection());
    }

    protected function hasStart(Model $model): bool
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
        return $model->cashier()->exists();
    }

    protected function hasAutoRefund(): bool
    {
        return Main::getAutoRefundEnabled();
    }

    protected function autoRefundDelay(): int
    {
        return Main::getAutoRefundDelay();
    }

    protected function onConnection(): ?string
    {
        return Main::getQueue()->getConnection();
    }

    protected function driver(Model $model): DriverContract
    {
        return DriverManager::fromModel($model);
    }

    protected function status(Model $model): Statuses
    {
        return $this->driver($model)->statuses();
    }
}
