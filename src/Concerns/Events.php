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
        $field = $this->attributeStatus();

        if ($payment->wasChanged($field) && $event = $this->getEvent($payment, $field)) {
            event(new $event($payment));
        }
    }

    protected function getEvent(Model $payment, string $field): ?string
    {
        return $this->getEventClass($this->getStatus(), $payment->getAttribute($field));
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
