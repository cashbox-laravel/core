<?php

/**
 * This file is part of the "cashbox/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashbox-laravel/foundation
 */

declare(strict_types=1);

namespace CashierProvider\Core\Observers;

use CashierProvider\Core\Concerns\Config\Payment\Attributes;
use CashierProvider\Core\Concerns\Config\Payment\Payments;
use CashierProvider\Core\Enums\StatusEnum;
use CashierProvider\Core\Models\Details;
use Illuminate\Database\Eloquent\Model;

class PaymentDetailsObserver
{
    use Attributes;
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

        if ($model->wasChanged('status')) {
            $this->updateStatus($model->parent, $model->status);
        }
    }

    protected function updateStatus(Model $payment, StatusEnum $status): void
    {
        $value = static::payment()->status->fromEnum($status);
        $field = static::attribute()->status;

        $payment->update([$field => $value]);
    }
}
