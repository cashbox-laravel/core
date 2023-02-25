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

namespace CashierProvider\Core\Console\Commands;

use CashierProvider\Core\Facades\Config;
use CashierProvider\Core\Models\CashierDetail;
use CashierProvider\Core\Services\Job;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('cashier:check')]
class Check extends Base
{
    protected $signature = 'cashier:check';

    protected $description = 'Launching a re-verification of payments with a long processing cycle';

    protected int $delay = 3600;

    public function handle()
    {
        $this->cleanup();
        $this->checkPayments();
    }

    protected function getStatuses(): array
    {
        return Config::payment()->status->inProgress();
    }

    protected function cleanup(): void
    {
        CashierDetail::query()
            ->whereDoesntHaveMorph('parent', $this->model())
            ->delete();
    }

    protected function checkPayments(): void
    {
        $this->payments()->chunk($this->chunk, fn (Collection $payments) => $payments->each(
            fn (Model $payment) => $this->check($payment, $this->delay($payment))
        ));
    }

    protected function check(Model $model, ?int $delay): void
    {
        Job::make($model)->check(true, $delay);
    }

    protected function delay(Model $model): ?int
    {
        return $this->isToday($model) ? null : $this->delay;
    }

    protected function isToday(Model $model): bool
    {
        $field = $this->attributeCreatedAt();

        /** @var \Carbon\Carbon $value */
        $value = $model->getAttribute($field);

        return $value->isToday();
    }
}
