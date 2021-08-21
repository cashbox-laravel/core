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
use Helldar\Cashier\Facades\Config\Payment;
use Helldar\Cashier\Facades\Helpers\DriverManager;
use Helldar\Cashier\Models\CashierDetail;
use Helldar\Cashier\Services\Jobs;
use Helldar\Contracts\Cashier\Driver as DriverContract;

class DetailsObserver
{
    public function saved(CashierDetail $model)
    {
        if ($model->isDirty()) {
            Jobs::make($model->parent)->check();
        }
    }

    public function updated(CashierDetail $model)
    {
        $statuses = $this->driver($model)->statuses();

        $status = $model->details->getStatus();

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
}
