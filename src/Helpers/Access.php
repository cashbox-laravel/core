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

namespace CashierProvider\Core\Helpers;

use CashierProvider\Core\Concerns\Casheable;
use CashierProvider\Core\Facades\Config\Payment;
use DragonCode\Support\Facades\Instances\Instance;
use Illuminate\Database\Eloquent\Model;

class Access
{
    public function allow(Model $model): bool
    {
        return $this->allowModel($model)
            && $this->allowType($model)
            && $this->allowMethod($model);
    }

    protected function types(): array
    {
        return Payment::getMap()->getTypes();
    }

    protected function type(Model $model)
    {
        $name = Payment::getAttributes()->getType();

        return $model->getAttribute($name);
    }

    protected function allowType(Model $model): bool
    {
        $types = $this->types();
        $type  = $this->type($model);

        return in_array($type, $types, true);
    }

    protected function model(): string
    {
        return Payment::getModel();
    }

    protected function allowModel(Model $model): bool
    {
        return Instance::of($model, $this->model());
    }

    protected function allowMethod(Model $model): bool
    {
        return Instance::of($model, Casheable::class);
    }
}
