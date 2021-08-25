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

namespace Helldar\Cashier\Observers;

use Helldar\Cashier\Constants\Status;
use Helldar\Cashier\Events\Payments\FailedEvent;
use Helldar\Cashier\Events\Payments\RefundEvent;
use Helldar\Cashier\Events\Payments\SuccessEvent;
use Helldar\Cashier\Facades\Config\Payment;
use Helldar\Cashier\Facades\Helpers\DriverManager;
use Helldar\Cashier\Models\CashierDetail;
use Helldar\Cashier\Services\Jobs;
use Helldar\Contracts\Cashier\Driver as DriverContract;
use Helldar\Contracts\Cashier\Helpers\Statuses;

class DetailsObserver
{
    public function saved(CashierDetail $model)
    {
        if ($model->isDirty()) {
            Jobs::make($model->parent)->check();
        }

        $statuses = $this->driver($model)->statuses();

        $status = $model->details->getStatus();

        $this->event($model, $statuses, $status);

        if ($model->wasChanged('details') && $statuses->hasRefunded($status)) {
            $this->updateStatus($model, Status::REFUND);

            return;
        }

        if ($model->wasChanged('details') && $statuses->hasFailed($status)) {
            $this->updateStatus($model, Status::FAILED);
        }
    }

    protected function driver(CashierDetail $model): DriverContract
    {
        return DriverManager::fromModel($model->parent);
    }

    protected function updateStatus(CashierDetail $model, string $status): void
    {
        $value = $this->status($status);

        $field = $this->statusField();

        $model->parent->update([$field => $value]);
    }

    protected function status(string $status)
    {
        return Payment::getStatuses()->getStatus($status);
    }

    protected function statusField(): string
    {
        return Payment::getAttributes()->getStatus();
    }

    protected function event(CashierDetail $detail, Statuses $statuses, ?string $status): void
    {
        if (! $detail->wasChanged('status') || empty($status)) {
            return;
        }

        switch (true) {
            case $statuses->hasSuccess($status):
                event(new SuccessEvent($detail));
                break;

            case $statuses->hasRefunded($status):
                event(new RefundEvent($detail));
                break;

            case $statuses->hasFailed($status):
                event(new FailedEvent($detail));
        }
    }
}
