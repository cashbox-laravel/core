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

namespace CashierProvider\Core\Observers;

use CashierProvider\Core\Concerns\Relations;
use CashierProvider\Core\Constants\Status;
use CashierProvider\Core\Facades\Config\Payment;
use CashierProvider\Core\Facades\Helpers\DriverManager;
use CashierProvider\Core\Models\CashierDetail;
use CashierProvider\Core\Services\Jobs;
use DragonCode\Contracts\Cashier\Driver as DriverContract;

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
