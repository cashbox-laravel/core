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

use CashierProvider\Core\Concerns\Attributes;
use CashierProvider\Core\Concerns\Casheable;
use CashierProvider\Core\Facades\Config;
use DragonCode\Support\Facades\Instances\Instance;
use Illuminate\Database\Eloquent\Model;

class Access
{
    use Attributes;

    public function allow(Model $model): bool
    {
        return $this->allowModel($model)
            && $this->allowType($model)
            && $this->allowMethod($model);
    }

    protected function type(Model $model)
    {
        return $model->getAttribute(
            $this->attributeType()
        );
    }

    protected function allowType(Model $model): bool
    {
        $types = $this->types();
        $type  = $this->type($model);

        return in_array($type, $types, true);
    }

    protected function model(): string
    {
        return Config::payment()->model;
    }

    protected function allowModel(Model $model): bool
    {
        return Instance::of($model, $this->model());
    }

    protected function allowMethod(Model $model): bool
    {
        return Instance::of($model, Casheable::class);
    }

    protected function types(): array
    {
        return Config::payment()->drivers->types();
    }
}
