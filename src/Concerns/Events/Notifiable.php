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

namespace Cashbox\Core\Concerns\Events;

use Cashbox\Core\Concerns\Config\Payment\Payments;
use Cashbox\Core\Enums\StatusEnum;
use Cashbox\Core\Events\PaymentCreatedEvent;
use Cashbox\Core\Events\PaymentFailedEvent;
use Cashbox\Core\Events\PaymentRefundedEvent;
use Cashbox\Core\Events\PaymentSuccessEvent;
use Cashbox\Core\Events\PaymentWaitRefundEvent;
use Illuminate\Database\Eloquent\Model;

trait Notifiable
{
    use Payments;

    protected static function event(Model $payment, StatusEnum $status): void
    {
        match ($status) {
            StatusEnum::New        => PaymentCreatedEvent::dispatch($payment),
            StatusEnum::Refund     => PaymentRefundedEvent::dispatch($payment),
            StatusEnum::WaitRefund => PaymentWaitRefundEvent::dispatch($payment),
            StatusEnum::Success    => PaymentSuccessEvent::dispatch($payment),
            StatusEnum::Failed     => PaymentFailedEvent::dispatch($payment),
        };
    }

    protected static function eventWithDetect(Model $payment): void
    {
        static::event($payment, static::detectEvent($payment));
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\Cashbox\Core\Billable  $payment
     */
    protected static function detectEvent(Model $payment): StatusEnum
    {
        return static::paymentConfig()->status->toEnum(
            $payment->cashboxAttributeStatus()
        );
    }
}
