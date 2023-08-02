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

namespace Cashbox\Core\Observers;

use Cashbox\Core\Concerns\Config\Payment\Attributes;
use Cashbox\Core\Concerns\Config\Payment\Payments;
use Cashbox\Core\Concerns\Events\Notifiable;
use Cashbox\Core\Enums\StatusEnum;
use Cashbox\Core\Models\Details;
use Illuminate\Database\Eloquent\Model;

class PaymentDetailsObserver
{
    use Attributes;
    use Notifiable;
    use Payments;

    public function created(Details $model): void
    {
        static::event($model->parent, $model->status);
    }

    public function saving(Details $model): void
    {
        if ($model->isDirty('info') && $status = $model->info->status) {
            $model->status = $model->parent->cashboxDriver()->statuses()->detect($status);
        }
    }

    public function saved(Details $model): void
    {
        $this->updateStatus($model->parent, $model->status);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\Cashbox\Core\Billable  $payment
     */
    protected function updateStatus(Model $payment, StatusEnum $status): void
    {
        $value = static::paymentConfig()->status->fromEnum($status);
        $field = static::attributeConfig()->status;

        $payment->update([$field => $value]);
    }
}
