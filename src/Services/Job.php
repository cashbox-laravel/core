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

namespace CashierProvider\Core\Services;

use CashierProvider\Core\Concerns\Config\Queue;
use CashierProvider\Core\Concerns\Config\Refund;
use CashierProvider\Core\Helpers\Access;
use CashierProvider\Core\Helpers\Validator;
use CashierProvider\Core\Jobs\RefundJob;
use CashierProvider\Core\Jobs\StartJob;
use CashierProvider\Core\Jobs\VerifyJob;
use Illuminate\Database\Eloquent\Model;

class Job
{
    use Queue;
    use Refund;

    protected bool $force = false;

    public function __construct(
        protected Model $payment
    ) {
        $this->validateModel($this->payment);
    }

    public static function model(Model $payment): self
    {
        return new static($payment);
    }

    public function start(): void
    {
        if ($this->allowToStart()) {
            $this->dispatch(StartJob::class, $this->queue()->name->start);

            if ($this->autoRefund()->enabled) {
                $this->refund($this->autoRefund()->delay);
            }
        }
    }

    public function verify(): void
    {
        if ($this->allowToVerify()) {
            $this->dispatch(VerifyJob::class, $this->queue()->name->verify);
        }
    }

    public function refund(?int $delay = null): void
    {
        if ($this->force || $this->allowToRefund()) {
            $this->dispatch(RefundJob::class, $this->queue()->name->refund, $delay);
        }
    }

    public function retry(): void
    {
        $this->start();
        $this->verify();
    }

    public function force(bool $force = true): self
    {
        $this->force = $force;

        return $this;
    }

    protected function dispatch(string $job, ?string $queue, ?int $delay = null): void
    {
        dispatch(new $job($this->payment, $this->force))
            ->onConnection($this->queue()->connection)
            ->onQueue($queue)
            ->afterCommit()
            ->delay($delay);
    }

    protected function allowToStart(): bool
    {
        return Access::toStart($this->payment);
    }

    protected function allowToVerify(): bool
    {
        return Access::toVerify($this->payment);
    }

    protected function allowToRefund(): bool
    {
        return Access::toRefund($this->payment);
    }

    protected function validateModel(Model $model): void
    {
        Validator::model($model);
    }
}
