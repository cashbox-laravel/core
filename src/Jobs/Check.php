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
use CashierProvider\Core\Events\Processes\Checked;
use CashierProvider\Core\Exceptions\Logic\UnknownExternalIdException;
use CashierProvider\Core\Facades\Config\Main;
use DragonCode\Contracts\Cashier\Http\Response;

class Check extends Base
{
    protected $event = Checked::class;

    public function handle()
    {
        $this->checkExternalId();

        $response = $this->process();

        $status = $response->getStatus();

        switch (true) {
            case $this->hasFailed($status):
                $this->update($response, Status::FAILED);
                break;

            case $this->hasRefunding($status):
                $this->update($response, Status::WAIT_REFUND);
                break;

            case $this->hasRefunded($status):
                $this->update($response, Status::REFUND);
                break;

            case $this->hasSuccess($status):
                $this->update($response, Status::SUCCESS);
                break;

            default:
                if ($this->hasBreak()) {
                    return;
                }

                $this->returnToQueue();
        }
    }

    protected function process(): Response
    {
        return $this->resolveDriver()->check();
    }

    protected function update(Response $response, string $status): void
    {
        $this->updateParentStatus($status);
        $this->store($response, false);
    }

    protected function queueName(): ?string
    {
        return Main::getQueue()->getNames()->getCheck();
    }

    protected function checkExternalId(): void
    {
        $this->resolveCashier($this->model);

        if (empty($this->model->cashier->external_id)) {
            $this->fail(
                new UnknownExternalIdException($this->model->getKey())
            );
        }
    }
}
