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

use core\src\Concerns\Config\Payment\Attributes;
use core\src\Concerns\Config\Payment\Drivers;
use CashierProvider\Core\Concerns\Config\Payment\Payments;
use CashierProvider\Core\Concerns\Config\Payment\Statuses;
use CashierProvider\Core\Services\Job;
use Closure;
use DragonCode\LaravelSupport\Traits\InitModelHelper;
use Illuminate\Console\Command as BaseCommand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class Command extends BaseCommand
{
    use Attributes;
    use Drivers;
    use Payments;
    use Statuses;
    use InitModelHelper;

    protected int $size = 1000;

    abstract protected function getStatuses(): array;

    abstract protected function process(Model $payment): void;

    public function handle(): void
    {
        $this->components->task($this->action(), fn () => $this->ran());
    }

    protected function ran(): void
    {
        $this->payments(fn (Collection $items) => $items->each(
            fn (Model $payment) => $this->process($payment)
        ));
    }

    protected function payments(Closure $callback): void
    {
        $this->builder()
            ->with('cashier')
            ->where(static::attribute()->type, $this->getTypes())
            ->where(static::attribute()->status, $this->getStatuses())
            ->chunkById($this->size, $callback);
    }

    protected function builder(): Builder
    {
        return $this->model()->query(
            static::payment()->model
        );
    }

    protected function getTypes(): array
    {
        return static::drivers()->keys()->toArray();
    }

    protected function job(Model $payment): Job
    {
        return Job::model($payment)->force(
            $this->hasForce()
        );
    }

    protected function action(): string
    {
        return Str::of(static::class)->classBasename()->append('ing')->toString();
    }

    protected function hasForce(): bool
    {
        return $this->hasOption('force') && $this->option('force');
    }
}
