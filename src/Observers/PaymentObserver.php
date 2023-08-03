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
 * @see https://cashbox.city
 */

declare(strict_types=1);

namespace Cashbox\Core\Observers;

use Cashbox\Core\Concerns\Config\Payment\Attributes;
use Cashbox\Core\Concerns\Config\Payment\Payments;
use Cashbox\Core\Concerns\Events\Notifiable;
use Cashbox\Core\Concerns\Permissions\Allowable;
use Illuminate\Database\Eloquent\Model;

class PaymentObserver
{
    use Allowable;
    use Attributes;
    use Payments;
    use Notifiable;

    public function creating(Model $payment): void
    {
        // Collision elimination when creating a model using the default value from the database.
        $column = static::attributeConfig()->status;
        $status = static::paymentConfig()->status->new;

        if ($payment->getAttribute($column) === null) {
            $payment->setAttribute($column, $status);
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\Cashbox\Core\Billable  $payment
     */
    public function created(Model $payment): void
    {
        if ($this->authorizeType($payment)) {
            $payment->cashboxJob()->start();
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\Cashbox\Core\Billable  $payment
     */
    public function updated(Model $payment): void
    {
        if (! $this->authorizeType($payment)) {
            return;
        }

        if ($this->wasChangedStatus($payment)) {
            static::eventWithDetect($payment);
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\Cashbox\Core\Billable  $payment
     */
    public function restored(Model $payment): void
    {
        if ($this->authorizeType($payment)) {
            $payment->cashboxJob(true)->retry();
        }
    }

    protected function wasChangedStatus(Model $payment): bool
    {
        return $payment->wasChanged(
            static::attributeConfig()->status
        );
    }
}
