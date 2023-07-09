<?php

namespace Tests\Fixtures\Resources;

use CashierProvider\Core\Resources\Model as BaseModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Tests\Fixtures\Models\OrderItem;
use Tests\Fixtures\Models\User;

/** @property \Tests\Fixtures\Models\ReadyPayment $model */
class Model extends BaseModel
{
    public function getShowCaseId(): ?string
    {
        return config('cashier.drivers.tinkoff_credit.show_case_id');
    }

    public function getPromoCode(): ?string
    {
        return config('cashier.drivers.tinkoff_credit.promocode');
    }

    public function getClient(): User
    {
        return new User();
    }

    public function getItems(): Collection
    {
        return collect([new OrderItem()])->map(function ($item) {
            return [
                'name'     => $item->name,
                'quantity' => $item->quantity,
                'price'    => (int) $item->price,
            ];
        });
    }

    public function getSum(): int
    {
        return (int) $this->sum();
    }

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
