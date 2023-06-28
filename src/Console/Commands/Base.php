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

use CashierProvider\Core\Concerns\Cache;
use CashierProvider\Core\Concerns\Config\Payment\Attributes;
use CashierProvider\Core\Concerns\Config\Payment\Drivers;
use CashierProvider\Core\Concerns\Config\Payment\Statuses;
use CashierProvider\Core\Facades\Config;
use Closure;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Base extends Command
{
    use Attributes;
    use Cache;
    use Drivers;
    use Statuses;

    protected int $size = 1000;

    abstract public function handle(): void;

    abstract protected function getStatuses(): array;

    protected function payments(Closure $callback): void
    {
        $this->builder()
            ->where($this->attributeType(), $this->getDrivers())
            ->where($this->attributeStatus(), $this->getStatuses())
            ->chunkById($this->size, $callback);
    }

    protected function builder(): Builder
    {
        $model = $this->model();

        return $model::query();
    }

    protected function model(): Model|string
    {
        return Config::payment()->model;
    }

    protected function getDrivers(): array
    {
        return $this->drivers()->keys()->toArray();
    }
}
