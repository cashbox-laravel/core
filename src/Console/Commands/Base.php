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

use Carbon\Carbon;
use CashierProvider\Core\Concerns\Attributes;
use CashierProvider\Core\Concerns\Driverable;
use CashierProvider\Core\Facades\Config;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Base extends Command
{
    use Attributes;
    use Driverable;

    protected int $chunk = 1000;

    abstract public function handle();

    abstract protected function getStatuses(): array;

    protected function model(): Model|string
    {
        return Config::payment()->model;
    }

    protected function payments(): Builder
    {
        $model = $this->model();

        return $model::query()
            ->whereIn($this->attributeType(), $this->attributeTypes())
            ->whereIn($this->attributeStatus(), $this->getStatuses())
            ->when($this->getCreatedAt(), fn (Builder $builder, Carbon $createdAt) => $builder
                ->where($this->attributeCreatedAt(), '<', $createdAt)
            );
    }

    protected function attributeTypes(): array
    {
        return Config::payment()->drivers->keys();
    }

    protected function getCreatedAt(): ?Carbon
    {
        return null;
    }
}
