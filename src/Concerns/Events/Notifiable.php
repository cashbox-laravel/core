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

namespace Cashbox\Core\Concerns\Events;

use Cashbox\Core\Concerns\Config\Payment\Attributes;
use Cashbox\Core\Concerns\Config\Payment\Payments;
use Cashbox\Core\Enums\StatusEnum;
use Cashbox\Core\Events\CreatedEvent;
use Cashbox\Core\Events\DeletedEvent;
use Cashbox\Core\Events\FailedEvent;
use Cashbox\Core\Events\RefundedEvent;
use Cashbox\Core\Events\SuccessEvent;
use Cashbox\Core\Events\WaitRefundEvent;
use Illuminate\Database\Eloquent\Model;

trait Notifiable
{
    use Attributes;
    use Payments;

    protected static function event(Model $payment, StatusEnum $status): void
    {
        match ($status) {
            StatusEnum::new        => event(new CreatedEvent($payment)),
            StatusEnum::refund     => event(new RefundedEvent($payment)),
            StatusEnum::waitRefund => event(new WaitRefundEvent($payment)),
            StatusEnum::success    => event(new SuccessEvent($payment)),
            StatusEnum::failed     => event(new FailedEvent($payment)),
            StatusEnum::deleted    => event(new DeletedEvent($payment)),
        };
    }

    protected static function eventWithDetect(Model $payment): void
    {
        static::event($payment, static::detectEvent($payment));
    }

    protected static function detectEvent(Model $payment): StatusEnum
    {
        $status = $payment->getAttribute(static::attribute()->status);

        return static::payment()->status->toEnum($status);
    }
}
