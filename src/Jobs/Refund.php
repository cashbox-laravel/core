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

use CashierProvider\Core\Constants\Status;
use CashierProvider\Core\Events\Processes\Refunded;
use CashierProvider\Core\Exceptions\Logic\AlreadyRefundedException;
use CashierProvider\Core\Exceptions\Logic\UnknownExternalIdException;
use DragonCode\Contracts\Cashier\Http\Response;
use Illuminate\Contracts\Bus\Dispatcher;

class Refund extends Base
{
    protected string $event = Refunded::class;

    public function handle()
    {
        $this->call(function () {
            $this->checkExternalId();

            $this->runCheckJob();

            $this->checkStatus();

            $this->ran();
        });
    }

    protected function process(): Response
    {
        return $this->resolveDriver()->refund();
    }

    protected function queueName(): ?string
    {
        return $this->resolveDriver()->queue()->refund;
    }

    protected function ran()
    {
        $response = $this->process();

        $status = $response->getStatus();

        if ($this->hasRefunding($status)) {
            $this->returnToQueue();

            return;
        }

        $this->updateParentStatus(Status::REFUND);

        $this->store($response, false);
    }

    protected function paymentId()
    {
        return $this->model->getKey();
    }

    protected function runCheckJob(): void
    {
        $job = new Check($this->model, true);

        app(Dispatcher::class)->dispatchNow($job);
    }

    protected function checkExternalId(): void
    {
        $this->resolveCashier($this->model);

        if (empty($this->model->cashier->external_id)) {
            $this->fail(
                new UnknownExternalIdException($this->paymentId())
            );
        }
    }

    protected function checkStatus(): void
    {
        if ($this->resolveStatuses()->hasRefunded()) {
            $this->fail(
                new AlreadyRefundedException($this->model->getKey())
            );
        }
    }
}
