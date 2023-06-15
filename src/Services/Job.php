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

use CashierProvider\Core\Concerns\Casheable;
use CashierProvider\Core\Concerns\Driverable;
use CashierProvider\Core\Facades\Access;
use CashierProvider\Core\Facades\Config;
use CashierProvider\Core\Jobs\Base;
use CashierProvider\Core\Jobs\Check;
use CashierProvider\Core\Jobs\Refund;
use CashierProvider\Core\Jobs\Start;
use DragonCode\Support\Concerns\Makeable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Model|Casheable $model
 *
 * @method static Job make(Model|Casheable $model)
 */
class Job
{
    use Driverable;
    use Makeable;

    public function __construct(
        protected Model $model
    ) {}

    public function start(): void
    {
        if ($this->hasStart($this->model)) {
            $this->retry();
        }
    }

    public function retry(): void
    {
        $this->send(Start::class);

        if ($this->hasAutoRefund()) {
            $this->refund($this->autoRefundDelay());
        }
    }

    public function check(bool $force = false, ?int $delay = null): void
    {
        if ($force || $this->hasCheck($this->model)) {
            $this->send(Check::class, $force, $delay);
        }
    }

    public function refund(?int $delay = null): void
    {
        $this->send(Refund::class, false, $delay);
    }

    protected function send(Base|string $job, bool $force = false, ?int $delay = null): void
    {
        dispatch(new $job($this->model, $force))
            ->onConnection($this->onConnection())
            ->delay($delay);
    }

    protected function hasStart(Model $model): bool
    {
        if (! $this->hasType($model)) {
            return false;
        }

        if (! $this->status($model)->hasCreated()) {
            return false;
        }

        return ! $this->hasRequested($model);
    }

    protected function hasCheck(Model $model): bool
    {
        if (! $this->hasType($model)) {
            return false;
        }

        return $this->status($model)->inProgress();
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
        return Config::refund()->enabled;
    }

    protected function autoRefundDelay(): int
    {
        return Config::refund()->delay;
    }

    protected function onConnection(): ?string
    {
        return Config::queue()->connection;
    }

    protected function status(Model $model): Statuses
    {
        return $this->driver($model->parent)->statuses();
    }
}
