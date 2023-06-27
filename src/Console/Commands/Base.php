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

use CashierProvider\Core\Concerns\Driverable;
use CashierProvider\Core\Constants\Status;
use CashierProvider\Core\Facades\Config\Payment;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

abstract class Base extends Command
{
    use Driverable;

    protected $count = 1000;

    abstract public function handle();

    /**
     * @return \Illuminate\Database\Eloquent\Model|string
     */
    protected function model(): string
    {
        return Payment::getModel();
    }

    protected function payments(): Builder
    {
        $model = $this->model();

        return $model::query()
            ->whereIn($this->attributeType(), $this->attributeTypes())
            ->where($this->attributeStatus(), $this->getStatus());
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
}
