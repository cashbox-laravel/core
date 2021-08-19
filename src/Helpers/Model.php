<?php

declare(strict_types=1);

namespace Helldar\Cashier\Helpers;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model
{
    /**
     * @param  \Helldar\Cashier\Concerns\Casheable|\Illuminate\Database\Eloquent\Model  $payment
     * @param  array  $data
     */
    public function updateOrCreate(EloquentModel $payment, array $data): void
    {
        $this->exists($payment)
            ? $this->update($payment, $data)
            : $this->create($payment, $data);
    }

    /**
     * @param  \Helldar\Cashier\Concerns\Casheable|\Illuminate\Database\Eloquent\Model  $payment
     * @param  array  $data
     */
    public function create(EloquentModel $payment, array $data): void
    {
        $payment->cashier()->create($data);
    }

    /**
     * @param  \Helldar\Cashier\Concerns\Casheable|\Illuminate\Database\Eloquent\Model  $payment
     * @param  array  $data
     */
    public function update(EloquentModel $payment, array $data): void
    {
        $payment->cashier()->update($data);
    }

    /**
     * @param  \Helldar\Cashier\Concerns\Casheable|\Illuminate\Database\Eloquent\Model  $model
     *
     * @return bool
     */
    public function exists(EloquentModel $model): bool
    {
        return $model->cashier()->exists();
    }
}
