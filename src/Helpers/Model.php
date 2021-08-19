<?php

declare(strict_types=1);

namespace Helldar\Cashier\Helpers;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model
{
    /**
     * @param  \Illuminate\Database\Eloquent\Model|\Helldar\Cashier\Concerns\Casheable  $payment
     * @param  array  $data
     */
    public function updateOrCreate(EloquentModel $payment, array $data): void
    {
        $this->exists($payment)
            ? $this->update($payment, $data)
            : $this->create($payment, $data);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\Helldar\Cashier\Concerns\Casheable  $payment
     * @param  array  $data
     *
     * @return void
     */
    public function create(EloquentModel $payment, array $data): void
    {
        $payment->cashier()->create($data);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\Helldar\Cashier\Concerns\Casheable  $payment
     * @param  array  $data
     *
     * @return void
     */
    public function update(EloquentModel $payment, array $data): void
    {
        $payment->cashier()->update($data);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\Helldar\Cashier\Concerns\Casheable  $model
     *
     * @return bool
     */
    public function exists(EloquentModel $model): bool
    {
        return $model->cashier()->exists();
    }
}
