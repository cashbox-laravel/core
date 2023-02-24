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

use CashierProvider\Core\Concerns\Attributes;
use CashierProvider\Core\Concerns\Driverable;
use CashierProvider\Core\Constants\Status;
use CashierProvider\Core\Facades\Config;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Base extends Command
{
    use Attributes;
    use Driverable;

    protected int $count = 1000;

    abstract public function handle();

    protected function model(): Model|string
    {
        return Config::payment()->model;
    }

    protected function payments(): Builder
    {
        $model = $this->model();

        return $model::query()
            ->whereIn($this->attributeType(), $this->attributeTypes())
            ->where($this->attributeStatus(), $this->getStatus());
    }

    protected function attributeTypes(): array
    {
        return Config::payment()->drivers->types();
    }

    protected function getStatus(): mixed
    {
        return Config::payment()->status->get(Status::NEW);
    }
}
