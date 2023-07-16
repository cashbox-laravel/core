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

namespace Cashbox\Core\Console\Commands;

use Cashbox\Core\Concerns\Config\Payment\Attributes;
use Cashbox\Core\Concerns\Config\Payment\Drivers;
use Cashbox\Core\Concerns\Config\Payment\Payments;
use Cashbox\Core\Concerns\Config\Payment\Statuses;
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
    use InitModelHelper;
    use Payments;
    use Statuses;

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
            ->with('cashbox.parent')
            ->where(static::attributeConfig()->type, $this->getTypes())
            ->where(static::attributeConfig()->status, $this->getStatuses())
            ->when($this->getPaymentId(), fn (Builder $builder, int|string $id) => $builder
                ->where($this->modelKey(), $id)
            )
            ->chunkById($this->size, $callback);
    }

    protected function builder(): Builder
    {
        return $this->model()->query(
            static::paymentConfig()->model
        );
    }

    protected function modelKey(): string
    {
        return $this->model()->primaryKey(
            static::paymentConfig()->model
        );
    }

    protected function getTypes(): array
    {
        return array_values(
            static::paymentConfig()->drivers
        );
    }

    protected function action(): string
    {
        return Str::of(static::class)->classBasename()->append('ing')->toString();
    }

    protected function hasForce(): bool
    {
        if ($this->hasOption('force') && $this->option('force')) {
            return true;
        }

        return $this->hasArgument('payment');
    }

    protected function getPaymentId(): int|string|null
    {
        if ($this->hasArgument('payment')) {
            return $this->argument('payment');
        }

        return null;
    }
}
