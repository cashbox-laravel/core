<?php

/**
 * This file is part of the "cashier-provider/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider/foundation
 */

declare(strict_types=1);

namespace CashierProvider\Core\Observers;

use CashierProvider\Core\Concerns\Config\Payment\Attributes;
use CashierProvider\Core\Concerns\Config\Payment\Drivers;
use CashierProvider\Core\Concerns\Config\Payment\Payments;
use CashierProvider\Core\Concerns\Events\Notifiable;
use CashierProvider\Core\Enums\StatusEnum;
use CashierProvider\Core\Models\Details;
use CashierProvider\Core\Services\Job;
use Illuminate\Database\Eloquent\Model;

class PaymentDetailsObserver
{
    use Attributes;
    use Drivers;
    use Notifiable;
    use Payments;

    public function saving(Details $model): void
    {
        if ($model->isDirty('info') && $model->status !== null) {
            $model->status = $model->info->statusToEnum();
        }
    }

    public function saved(Details $model): void
    {
        if ($model->isClean()) {
            return;
        }

        if ($model->wasChanged('status') || $this->isDoesntSameStatus($model)) {
            $this->updateStatus($model->parent, $model->status);

            static::event($model->parent, $model->status);
        }

        Job::model($model->parent)->verify();
    }

    protected function isDoesntSameStatus(Details $model): bool
    {
        return $model->status !== static::payment()->status->toEnum($this->paymentStatus($model->parent));
    }

    protected function updateStatus(Model $payment, StatusEnum $status): void
    {
        $value = static::payment()->status->fromEnum($status);
        $field = static::attribute()->status;

        $payment->update([$field => $value]);
    }

    protected function paymentStatus(Model $payment): mixed
    {
        return $payment->getAttribute(
            static::attribute()->status
        );
    }
}
