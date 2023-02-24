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

namespace CashierProvider\Core\Services;

use CashierProvider\Core\Concerns\Unique;
use CashierProvider\Core\Facades\Config\Main;
use CashierProvider\Core\Facades\Helpers\Access;
use CashierProvider\Core\Facades\Helpers\DriverManager;
use CashierProvider\Core\Jobs\Check;
use CashierProvider\Core\Jobs\Refund;
use CashierProvider\Core\Jobs\Start;
use DragonCode\Contracts\Cashier\Driver as DriverContract;
use DragonCode\Contracts\Cashier\Helpers\Statuses;
use DragonCode\Support\Concerns\Makeable;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Jobs make(Model $model)
 */
class Jobs
{
    use Makeable;
    use Unique;

    /** @var \Illuminate\Database\Eloquent\Model */
    protected Model $model;

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

    public function check(bool $force = false, ?int $delay = null)
    {
        if ($force || $this->hasCheck($this->model)) {
            $this->send(Check::class, $force, $delay);
        }
    }

    public function refund(?int $delay = null): void
    {
        $this->send(Refund::class, false, $delay);
    }

    /**
     * @param \CashierProvider\Core\Jobs\Base|string $job
     * @param bool $force
     * @param int|null $delay
     */
    protected function send(string $job, bool $force = false, ?int $delay = null): void
    {
        $instance = $job::make($this->model, $force)->delay($delay);

        if ($force || $this->uniqueAllow($instance)) {
            dispatch($instance)->onConnection($this->onConnection());

            $this->uniqueStore($instance);
        }
    }

    protected function hasStart(Model $model): bool
    {
        if (! $this->hasType($model)) {
            return false;
        }

        if (! $this->status($model)->hasCreated()) {
            return false;
        }

        return ! ($this->hasRequested($model));
    }

    protected function hasCheck(Model $model): bool
    {
        if (! $this->hasType($model)) {
            return false;
        }

        return ! (! $this->status($model)->inProgress());
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
