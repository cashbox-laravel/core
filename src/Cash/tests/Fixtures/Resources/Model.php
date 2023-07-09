<?php

namespace Tests\Fixtures\Resources;

use CashierProvider\Core\Resources\Model as BaseModel;
use Illuminate\Support\Carbon;

/** @property \Tests\Fixtures\Models\ReadyPayment $model */
class Model extends BaseModel
{
    protected function paymentId(): string
    {
        return $this->model->uuid;
    }

    protected function sum(): float
    {
        return $this->model->sum;
    }

    protected function currency(): int
    {
        return $this->model->currency;
    }

    protected function createdAt(): Carbon
    {
        return $this->model->created_at;
    }
}
