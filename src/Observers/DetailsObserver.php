<?php

declare(strict_types=1);

namespace Helldar\Cashier\Observers;

use Helldar\Cashier\Constants\Status;
use Helldar\Cashier\Facades\Config\Payment;
use Helldar\Cashier\Facades\Helpers\Driver;
use Helldar\Cashier\Models\CashierDetail;
use Helldar\Contracts\Cashier\Driver as DriverContract;

class DetailsObserver
{
    public function updated(CashierDetail $model)
    {
        $statuses = $this->driver($model)->statuses();

        $status = $model->details->getStatus();

        if ($model->wasChanged('details') && $statuses->hasRefunded($status)) {
            $this->updateStatus($model, Status::REFUND);
        }

        if ($model->wasChanged('details') && $statuses->hasFailed($status)) {
            $this->updateStatus($model, Status::FAILED);
        }
    }

    protected function driver(CashierDetail $model): DriverContract
    {
        return Driver::fromModel($model->parent);
    }

    protected function updateStatus(CashierDetail $model, string $status): void
    {
        $value = $this->status($status);

        $field = $this->statusField();

        $model->parent()->update([$field => $value]);
    }

    protected function status(string $status)
    {
        return Payment::status($status);
    }

    protected function statusField(): string
    {
        return Payment::attributeStatus();
    }
}
