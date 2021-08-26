<?php

declare(strict_types=1);

namespace Helldar\Cashier\Concerns;

use Helldar\Cashier\Facades\Helpers\DriverManager;
use Helldar\Contracts\Cashier\Driver;
use Illuminate\Database\Eloquent\Model;

trait Driverable
{
    /** @var \Helldar\Contracts\Cashier\Driver */
    protected $driver;

    /**
     * @param  \Helldar\Cashier\Concerns\Casheable|\Illuminate\Database\Eloquent\Model  $payment
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
