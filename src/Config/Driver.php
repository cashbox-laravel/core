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

namespace CashierProvider\Core\Config;

use CashierProvider\Core\Facades\Config\Main as MainConfig;
use DragonCode\Contracts\Cashier\Config\Driver as DriverContract;
use DragonCode\Contracts\Cashier\Config\Queues\Names;
use DragonCode\SimpleDataTransferObject\DataTransferObject;

class Driver extends DataTransferObject implements DriverContract
{
    protected $driver;

    protected $details;

    protected $client_id;

    protected $client_secret;

    protected $queue;

    public function getDriver(): string
    {
        return $this->driver;
    }

    public function getDetails(): string
    {
        return $this->details;
    }

    public function getClientId(): ?string
    {
        return $this->client_id;
    }

    public function getClientSecret(): ?string
    {
        return $this->client_secret;
    }

    public function getQueue(): Names
    {
        if ($this->queue) {
            return Queues\Names::make($this->queue);
        }

        return MainConfig::getQueue()->getNames();
    }
}
