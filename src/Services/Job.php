<?php

/**
 * This file is part of the "cashier-provider/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider/foundation
 */

declare(strict_types=1);

namespace CashierProvider\Core\Services;

use CashierProvider\Core\Concerns\Config\Queue;
use CashierProvider\Core\Concerns\Config\Refund;
use CashierProvider\Core\Concerns\Helpers\Validatable;
use CashierProvider\Core\Concerns\Permissions\Allowable;
use CashierProvider\Core\Data\Config\Queue\QueueNameData;
use CashierProvider\Core\Jobs\RefundJob;
use CashierProvider\Core\Jobs\StartJob;
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
            $this->dispatch(StartJob::class, $this->detectQueue()->start);

            if (static::autoRefund()->enabled) {
                $this->refund(static::autoRefund()->delay);
            }
        }
    }

    public function verify(): void
    {
        if ($this->authorizeToVerify()) {
            $this->dispatch(VerifyJob::class, $this->detectQueue()->verify);
        }
    }

    public function refund(?int $delay = null): void
    {
        if ($this->force || $this->authorizeToRefund()) {
            $this->dispatch(RefundJob::class, $this->detectQueue()->refund, $delay);
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

    protected function detectQueue(): QueueNameData
    {
        return static::queueName($this->payment);
    }
}
