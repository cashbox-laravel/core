<?php

declare(strict_types=1);

namespace Helldar\Cashier\Console\Commands;

use Helldar\Cashier\Facades\Config\Payment;
use Illuminate\Console\Command;

abstract class Base extends Command
{
    abstract public function handle();

    /**
     * @return \Illuminate\Database\Eloquent\Model|string
     */
    protected function model(): string
    {
        return Payment::getModel();
    }
}
