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

namespace Helldar\Cashier\Helpers;

use Helldar\Cashier\Concerns\Relations;
use Helldar\Cashier\Concerns\Validators;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model
{
    use Relations;
    use Validators;

    /**
     * @param  \Helldar\Cashier\Concerns\Casheable|\Illuminate\Database\Eloquent\Model  $payment
     * @param  array  $data
     */
    public function updateOrCreate(EloquentModel $payment, array $data): void
    {
        $this->validateModel($payment);

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
        $this->validateModel($payment);

        $payment->cashier()->create($data);
    }

    /**
     * @param  \Helldar\Cashier\Concerns\Casheable|\Illuminate\Database\Eloquent\Model  $payment
     * @param  array  $data
     */
    public function update(EloquentModel $payment, array $data): void
    {
        $this->validateModel($payment);

        $this->resolveCashier($payment);

        $payment->cashier->update($data);
    }

    /**
     * @param  \Helldar\Cashier\Concerns\Casheable|\Illuminate\Database\Eloquent\Model  $model
     *
     * @return bool
     */
    public function exists(EloquentModel $model): bool
    {
        $this->validateModel($model);

        return $model->cashier()->exists();
    }
}
