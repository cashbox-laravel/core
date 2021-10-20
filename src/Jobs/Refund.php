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

namespace CashierProvider\Core\Jobs;

use CashierProvider\Core\Constants\Status;
use CashierProvider\Core\Events\Processes\Refunded;
use CashierProvider\Core\Exceptions\Logic\AlreadyRefundedException;
use CashierProvider\Core\Exceptions\Logic\UnknownExternalIdException;
use CashierProvider\Core\Facades\Config\Main;
use Helldar\Contracts\Cashier\Http\Response;
use Illuminate\Contracts\Bus\Dispatcher;

class Refund extends Base
{
    protected $event = Refunded::class;

    /**
     * @throws \CashierProvider\Core\Exceptions\Logic\EmptyResponseException
     */
    public function handle()
    {
        $this->checkExternalId();

        $this->runCheckJob();

        $this->checkStatus();

        $this->ran();
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

    protected function process(): Response
    {
        return $this->resolveDriver()->refund();
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

    protected function queueName(): ?string
    {
        return Main::getQueue()->getNames()->getRefund();
    }
}
