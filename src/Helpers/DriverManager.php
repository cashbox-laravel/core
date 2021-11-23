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

use CashierProvider\Core\Concerns\Validators;
use CashierProvider\Core\Facades\Config\Main;
use CashierProvider\Core\Facades\Config\Payment;
use DragonCode\Contracts\Cashier\Config\Driver;
use DragonCode\Contracts\Cashier\Driver as Contract;
use Illuminate\Database\Eloquent\Model;

class DriverManager
{
    use Validators;

    /**
     * @param  \CashierProvider\Core\Concerns\Casheable|\Illuminate\Database\Eloquent\Model  $model
     *
     * @return \DragonCode\Contracts\Cashier\Driver
     */
    public function fromModel(Model $model): Contract
    {
        $this->validateModel($model);

        $type = $this->type($model);

        $name = $this->getDriverName($type);

        $driver = $this->getDriver($name);

        return $this->resolve($driver, $model);
    }

    protected function type(Model $model)
    {
        $type = $this->getTypeAttribute();

        return $model->getAttribute($type);
    }

    protected function getTypeAttribute(): string
    {
        return Payment::getAttributes()->getType();
    }

    protected function getDriverName($type): string
    {
        return Payment::getMap()->get($type);
    }

    protected function getDriver(string $name): Driver
    {
        return Main::getDriver($name);
    }

    protected function resolve(Driver $config, Model $payment): Contract
    {
        $driver = $config->getDriver();

        $this->validateDriver($driver);
        $this->validateModel($payment);

        return $driver::make($config, $payment);
    }
}
