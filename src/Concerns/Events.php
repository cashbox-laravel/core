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

use CashierProvider\Core\Constants\Status;
use CashierProvider\Core\Events\Payments\FailedEvent;
use CashierProvider\Core\Events\Payments\RefundEvent;
use CashierProvider\Core\Events\Payments\SuccessEvent;
use CashierProvider\Core\Facades\Config\Payment;
use DragonCode\Support\Facades\Helpers\Arr;
use Illuminate\Database\Eloquent\Model;

trait Events
{
    protected array $events = [
        Status::SUCCESS => SuccessEvent::class,
        Status::REFUND  => RefundEvent::class,
        Status::FAILED  => FailedEvent::class,
    ];

    protected function event(Model $payment): void
    {
        $status = $this->getStatusCode($payment);

        if ($event = Arr::get($this->events, $status)) {
            event(new $event($payment));
        }
    }

    protected function getStatusCode(Model $payment): ?string
    {
        $key = $this->attributeStatus();

        if (! $payment->wasChanged($key)) {
            return null;
        }

        $value = $payment->getAttribute($key);

        return $this->getStatus($value);
    }

    protected function getStatus($status): ?string
    {
        return Arr::get($this->getAvailableStatuses(), $status);
    }

    protected function getAvailableStatuses(): array
    {
        return array_flip(
            Payment::getStatuses()->statuses
        );
    }
}
