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

namespace Helldar\Cashier\Concerns;

use Helldar\Cashier\Constants\Status;
use Helldar\Cashier\Events\Payments\FailedEvent;
use Helldar\Cashier\Events\Payments\RefundEvent;
use Helldar\Cashier\Events\Payments\SuccessEvent;
use Helldar\Cashier\Facades\Config\Payment;
use Helldar\Support\Facades\Helpers\Arr;
use Illuminate\Database\Eloquent\Model;

trait Events
{
    protected $events = [
        Status::SUCCESS => SuccessEvent::class,
        Status::REFUND  => RefundEvent::class,
        Status::FAILED  => FailedEvent::class,
    ];

    protected function event(Model $payment): void
    {
        $status = $this->getStatusCode($payment);

        if (array_key_exists($status, $this->events)) {
            $event = Arr::get($this->events, $status);

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

    protected function attributeStatus(): string
    {
        return Payment::getAttributes()->getStatus();
    }

    protected function getStatus($status): ?string
    {
        return Arr::get($this->getAvailableStatuses(), $status);
    }

    protected function getAvailableStatuses(): array
    {
        $statuses = Payment::getStatuses()->getAll();

        return array_flip($statuses);
    }
}
