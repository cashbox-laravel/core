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

namespace Helldar\Cashier\Console\Commands;

use Helldar\Cashier\Constants\Status;
use Helldar\Cashier\Facades\Config\Payment;
use Helldar\Cashier\Models\CashierDetail;
use Helldar\Cashier\Services\Jobs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class Check extends Base
{
    protected $signature = 'cashier:check';

    protected $description = 'Launching a re-verification of payments with a long processing cycle';

    protected $count = 1000;

    public function handle()
    {
        $this->cleanup();
        $this->checkPayments();
    }

    protected function cleanup(): void
    {
        CashierDetail::query()
            ->whereDoesntHave('parent')
            ->delete();
    }

    protected function checkPayments(): void
    {
        $this->payments()->chunk($this->count, function (Collection $payments) {
            $payments->each(function (Model $payment) {
                $this->hasCancel($payment)
                    ? $this->cancel($payment)
                    : $this->check($payment);
            });
        });
    }

    protected function payments(): Builder
    {
        $model = $this->model();

        return $model::query()
            ->whereIn($this->attributeType(), $this->attributeTypes())
            ->where($this->attributeStatus(), $this->getStatus())
            ->where($this->attributeCreatedAt(), '<', $this->before());
    }

    protected function check(Model $model): void
    {
        Jobs::make($model)->check(true);
    }

    protected function cancel(Model $model): void
    {
        Jobs::make($model)->refund();
    }

    protected function attributeType(): string
    {
        return Payment::getAttributes()->getType();
    }

    protected function attributeTypes(): array
    {
        return Payment::getMap()->getTypes();
    }

    protected function attributeStatus(): string
    {
        return Payment::getAttributes()->getStatus();
    }

    protected function attributeCreatedAt(): string
    {
        return Payment::getAttributes()->getCreatedAt();
    }

    protected function getStatus()
    {
        return Payment::getStatuses()->getStatus(Status::NEW);
    }

    protected function before(): Carbon
    {
        return Carbon::now()->subHour();
    }

    protected function hasCancel(Model $payment): bool
    {
        return $this->allowCancelByDate($payment)
            && $this->allowCancelByStatus($payment);
    }

    protected function allowCancelByDate(Model $payment): bool
    {
        $attribute = $this->attributeCreatedAt();

        /** @var \Carbon\Carbon $value */
        $value = $payment->getAttribute($attribute);

        $now = Carbon::now()->subDay();

        return $value->lte($now);
    }

    protected function allowCancelByStatus(Model $payment): bool
    {
        $statuses = $this->driver($payment)->statuses();

        return $statuses->inProgress() || $statuses->hasFailed();
    }
}
