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

use CashierProvider\Core\Enums\Status;
use CashierProvider\Core\Events\Processes\Checked;
use CashierProvider\Core\Exceptions\Logic\UnknownExternalIdException;
use CashierProvider\Core\Facades\Config;
use CashierProvider\Core\Http\Response;
use Illuminate\Support\Carbon;

class Check extends Base
{
    protected string $event = Checked::class;

    protected bool $doneInsteadThrow = true;

    public function handle()
    {
        $this->call(function () {
            $this->checkExternalId();

            $response = $this->process();

            $status = $response->getStatus();

            switch (true) {
                case $this->hasFailed($status):
                    $this->update($response, Status::failed);
                    break;

                case $this->hasRefunding($status):
                    $this->update($response, Status::waitRefund);
                    break;

                case $this->hasRefunded($status):
                    $this->update($response, Status::refund);
                    break;

                case $this->hasSuccess($status):
                    $this->update($response, Status::success);
                    break;

                default:
                    if ($this->hasBreak()) {
                        return;
                    }

                    $this->returnToQueue();
            }
        });
    }

    protected function process(): Response
    {
        return $this->resolveDriver()->check();
    }

    protected function queueName(): ?string
    {
        return $this->resolveDriver()->queue()->check;
    }

    public function retryUntil(): ?Carbon
    {
        return Carbon::now()->addSeconds(
            Config::check()->timeout
        );
    }

    protected function update(Response $response, Status $status): void
    {
        $this->updateParentStatus($status);
        $this->store($response, false);
    }

    protected function checkExternalId(): void
    {
        if (empty($this->model->cashier->external_id)) {
            $this->fail(
                new UnknownExternalIdException($this->model->getKey())
            );
        }
    }
}
