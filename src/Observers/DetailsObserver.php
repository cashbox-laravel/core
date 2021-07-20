<?php

namespace Helldar\Cashier\Observers;

use Helldar\Cashier\Constants\Status;
use Helldar\Cashier\Contracts\Driver;
use Helldar\Cashier\Facades\Config\Payment;
use Helldar\Cashier\Models\CashierDetail;

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

    protected function driver(CashierDetail $model): Driver
    {
        return \Helldar\Cashier\Facades\Helpers\Driver::fromModel($model->parent);
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
