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

use core\src\Concerns\Config\Queue;
use CashierProvider\Core\Concerns\Config\Refund;
use CashierProvider\Core\Concerns\Helpers\Validatable;
use CashierProvider\Core\Concerns\Permissions\Allowable;
use CashierProvider\Core\Jobs\RefundJob;
use core\src\Jobs\StartJob;
use CashierProvider\Core\Jobs\VerifyJob;
use Illuminate\Database\Eloquent\Model;

class Job
{
    use Allowable;
    use Queue;
    use Refund;
    use Validatable;

    protected bool $force = false;

    public function __construct(
        protected Model $payment
    ) {
        static::validateModel($this->payment);
    }

    public static function model(Model $payment): self
    {
        return new static($payment);
    }

    public function start(): void
    {
        if ($this->authorizeToStart()) {
            $this->dispatch(StartJob::class, static::queue()->name->start);

            if (static::autoRefund()->enabled) {
                $this->refund(static::autoRefund()->delay);
            }
        }
    }

    public function verify(): void
    {
        if ($this->authorizeToVerify()) {
            $this->dispatch(VerifyJob::class, static::queue()->name->verify);
        }
    }

    public function refund(?int $delay = null): void
    {
        if ($this->force || $this->authorizeToRefund()) {
            $this->dispatch(RefundJob::class, static::queue()->name->refund, $delay);
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
            ->onConnection(static::queue()->connection)
            ->onQueue($queue)
            ->afterCommit()
            ->delay($delay);
    }
}
