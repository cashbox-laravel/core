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

namespace CashierProvider\Manager\Observers;

use CashierProvider\Manager\Concerns\Relations;
use CashierProvider\Manager\Constants\Status;
use CashierProvider\Manager\Facades\Config\Payment;
use CashierProvider\Manager\Facades\Helpers\DriverManager;
use CashierProvider\Manager\Models\CashierDetail;
use CashierProvider\Manager\Services\Jobs;
use Helldar\Contracts\Cashier\Driver as DriverContract;

class DetailsObserver extends BaseObserver
{
    use Relations;

    public function saved(CashierDetail $model)
    {
        if ($model->isClean()) {
            return;
        }

        $statuses = $this->driver($model)->statuses();

        $status = $model->details->getStatus();

        if ($model->isDirty('details')) {
            switch (true) {
                case $statuses->hasSuccess($status):
                    $this->updateStatus($model, Status::SUCCESS);

                    return;

                case $statuses->hasRefunded($status):
                    $this->updateStatus($model, Status::REFUND);

                    return;

                case $statuses->hasFailed($status):
                    $this->updateStatus($model, Status::FAILED);

                    return;
            }
        }

        $this->resolvePayment($model);

        Jobs::make($model->parent)->check();
    }

    protected function driver(CashierDetail $model): DriverContract
    {
        $this->resolvePayment($model);

        return DriverManager::fromModel($model->parent);
    }

    protected function updateStatus(CashierDetail $model, string $status): void
    {
        $this->resolvePayment($model);

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
