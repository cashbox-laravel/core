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

namespace CashierProvider\Manager\Config\Queues;

use Helldar\Contracts\Cashier\Config\Queues\Unique as Contract;
use Helldar\SimpleDataTransferObject\DataTransferObject;

class Unique extends DataTransferObject implements Contract
{
    protected $driver;

    protected $seconds;

    public function getDriver(): string
    {
        return $this->driver;
    }

    public function getSeconds(): int
    {
        $value = abs($this->seconds);

        return $value > 0 ? $value : 3600;
    }
}
