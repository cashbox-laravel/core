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

namespace CashierProvider\Core\Jobs;

use CashierProvider\Core\Enums\Status;
use CashierProvider\Core\Events\Processes\CheckedEvent;
use CashierProvider\Core\Exceptions\Logic\UnknownExternalIdException;
use CashierProvider\Core\Facades\Config;
use CashierProvider\Core\Http\Response;
use Illuminate\Support\Carbon;

use function now;

class Check extends Base
{
    protected string $event = CheckedEvent::class;

    protected bool $doneInsteadThrow = true;

    public function handle(): void
    {
        $this->call(function () {
            $this->checkExternalId();

            $response = $this->process();

            if ($status = $this->findStatus($response->getStatus())) {
                $this->update($response, $status);

                return;
            }

            if (! $this->hasBreak()) {
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
        return now()->addSeconds(
            Config::check()->timeout
        );
    }

    protected function findStatus(?string $status): ?Status
    {
        return match (true) {
            $this->hasFailed($status) => Status::failed,
            $this->hasRefunding($status) => Status::waitRefund,
            $this->hasRefunded($status) => Status::refund,
            $this->hasSuccess($status) => Status::success,
            default => null
        };
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
