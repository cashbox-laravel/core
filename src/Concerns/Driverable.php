<?php

/*
 * This file is part of the "andrey-helldar/cashier" project.
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
 * @see https://github.com/andrey-helldar/cashier
 */

declare(strict_types=1);

namespace CashierProvider\Manager\Concerns;

use CashierProvider\Manager\Facades\Helpers\DriverManager;
use Helldar\Contracts\Cashier\Driver;
use Illuminate\Database\Eloquent\Model;

trait Driverable
{
    /** @var \Helldar\Contracts\Cashier\Driver */
    protected $driver;

    /**
     * @param  \CashierProvider\Manager\Concerns\Casheable|\Illuminate\Database\Eloquent\Model  $payment
     *
     * @return \Helldar\Contracts\Cashier\Driver
     */
    protected function driver(Model $payment): Driver
    {
        if (! empty($this->driver)) {
            return $this->driver;
        }

        return $this->driver = DriverManager::fromModel($payment);
    }
}
