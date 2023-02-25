<?php

/*
 * This file is part of the "cashier-provider/core" project.
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
 * @see https://github.com/cashier-provider/core
 */

declare(strict_types=1);

namespace CashierProvider\Core\Concerns;

use CashierProvider\Core\Data\Config\Payment\Status;
use CashierProvider\Core\Events\Payments\FailedEvent;
use CashierProvider\Core\Events\Payments\RefundEvent;
use CashierProvider\Core\Events\Payments\SuccessEvent;
use CashierProvider\Core\Facades\Config;
use Illuminate\Database\Eloquent\Model;

trait Events
{
    protected function event(Model $payment): void
    {
        if ($payment->wasChanged($this->attributeStatus()) && $event = $this->getEvent($payment)) {
            event(new $event($payment));
        }
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model|\CashierProvider\Core\Concerns\Casheable $payment
     *
     * @return string|null
     */
    protected function getEvent(Model $payment): ?string
    {
        return $this->getEventClass($this->getStatus(), $payment->cashierStatus());
    }

    protected function getEventClass(Status $data, string|int $status): ?string
    {
        return match ($status) {
            $data->success    => SuccessEvent::class,
            $data->refund     => RefundEvent::class,
            $data->waitRefund => FailedEvent::class,
            default           => null
        };
    }

    protected function getStatus(): Status
    {
        return Config::payment()->status;
    }
}
