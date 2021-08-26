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

namespace Helldar\Cashier\Jobs;

use Helldar\Cashier\Constants\Status;
use Helldar\Cashier\Exceptions\Logic\AlreadyRefundedException;
use Helldar\Cashier\Exceptions\Logic\UnknownExternalIdException;
use Helldar\Contracts\Cashier\Http\Response;
use Illuminate\Contracts\Bus\Dispatcher;

class Refund extends Base
{
    /**
     * @throws \Helldar\Cashier\Exceptions\Logic\AlreadyRefundedException
     * @throws \Helldar\Cashier\Exceptions\Logic\UnknownExternalIdException
     * @throws \Helldar\Cashier\Exceptions\Logic\EmptyResponseException
     */
    public function handle()
    {
        $this->checkExternalId();

        $this->runCheckJob();

        $this->checkStatus();

        $this->ran();
    }

    /**
     * @throws \Helldar\Cashier\Exceptions\Logic\EmptyResponseException
     */
    protected function ran()
    {
        $response = $this->process();

        $status = $response->getStatus();

        if ($this->hasRefunding($status)) {
            $this->returnToQueue();

            return;
        }

        $this->updateParentStatus(Status::REFUND);

        $this->store($response);
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

    /**
     * @throws \Helldar\Cashier\Exceptions\Logic\UnknownExternalIdException
     */
    protected function checkExternalId(): void
    {
        if (empty($this->model->cashier->external_id)) {
            throw new UnknownExternalIdException($this->paymentId());
        }
    }

    /**
     * @throws \Helldar\Cashier\Exceptions\Logic\AlreadyRefundedException
     */
    protected function checkStatus(): void
    {
        if ($this->resolveStatuses()->hasRefunded()) {
            throw new AlreadyRefundedException($this->model->getKey());
        }
    }
}
