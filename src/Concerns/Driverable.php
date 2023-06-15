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

namespace CashierProvider\Core\Concerns;

use CashierProvider\Core\Facades\DriverManager;
use CashierProvider\Core\Services\Driver;
use Illuminate\Database\Eloquent\Model;

trait Driverable
{
    protected array $driver = [];

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\CashierProvider\Core\Concerns\Casheable  $payment
     */
    protected function driver(Model $payment): Driver
    {
        if (isset($this->driver[$payment->cashierType()])) {
            return $this->driver[$payment->cashierType()];
        }

        return $this->driver[$payment->cashierType()] = DriverManager::fromModel($payment);
    }
}
