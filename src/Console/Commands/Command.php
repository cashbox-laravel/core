<?php

/**
 * This file is part of the "cashier-provider/core" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider
 */

declare(strict_types=1);

namespace CashierProvider\Core\Console\Commands;

use CashierProvider\Core\Concerns\Config\Payment\Attributes;
use CashierProvider\Core\Concerns\Config\Payment\Drivers;
use CashierProvider\Core\Concerns\Config\Payment\Payments;
use CashierProvider\Core\Concerns\Config\Payment\Statuses;
use CashierProvider\Core\Services\Job;
use Closure;
use Illuminate\Console\Command as BaseCommand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class Command extends BaseCommand
{
    use Attributes;
    use Drivers;
    use Payments;
    use Statuses;

    protected int $size = 1000;

    abstract public function handle(): void;

    abstract protected function getStatuses(): array;

    abstract protected function process(Model $payment): void;

    protected function ran(): void
    {
        $this->payments(fn (Collection $items) => $items->each(
            fn (Model $payment) => $this->process($payment)
        ));
    }

    protected function payments(Closure $callback): void
    {
        $this->builder()
            ->where($this->attribute()->type, $this->getTypes())
            ->where($this->attribute()->status, $this->getStatuses())
            ->chunkById($this->size, $callback);
    }

    protected function builder(): Builder
    {
        $model = $this->payment()->model;

        return $model::query();
    }

    protected function getTypes(): array
    {
        return $this->drivers()->keys()->toArray();
    }

    protected function job(Model $payment): Job
    {
        return Job::model($payment)->force(
            $this->hasForce()
        );
    }

    protected function hasForce(): bool
    {
        return $this->hasOption('force') && $this->option('force');
    }
}
