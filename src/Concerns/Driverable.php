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

use CashierProvider\Core\Facades\Helpers\DriverManager;
use DragonCode\Contracts\Cashier\Driver;
use Illuminate\Database\Eloquent\Model;

trait Driverable
{
    protected Driver $driver;

    /**
     * @param \CashierProvider\Core\Concerns\Casheable|\Illuminate\Database\Eloquent\Model $payment
     *
     * @return \DragonCode\Contracts\Cashier\Driver
     */
    protected function driver(Model $payment): Driver
    {
        if (! empty($this->driver)) {
            return $this->driver;
        }

        return $this->driver = DriverManager::fromModel($payment);
    }
}
