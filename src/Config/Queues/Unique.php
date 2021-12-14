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

namespace CashierProvider\Core\Config\Queues;

use DragonCode\Contracts\Cashier\Config\Queues\Unique as Contract;
use DragonCode\SimpleDataTransferObject\DataTransferObject;

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

        return $value > 0 ? $value : 300;
    }
}
