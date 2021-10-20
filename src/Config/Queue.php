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

namespace CashierProvider\Manager\Config;

use Helldar\Contracts\Cashier\Config\Queue as QueueContract;
use Helldar\Contracts\Cashier\Config\Queues\Names;
use Helldar\Contracts\Cashier\Config\Queues\Unique;
use Helldar\SimpleDataTransferObject\DataTransferObject;

class Queue extends DataTransferObject implements QueueContract
{
    protected $connection;

    protected $names = [];

    protected $after_commit = true;

    protected $tries = 100;

    protected $unique = [];

    public function getConnection(): ?string
    {
        return $this->connection;
    }

    public function getNames(): Names
    {
        return Queues\Names::make($this->names);
    }

    public function afterCommit(): bool
    {
        return $this->after_commit;
    }

    public function getTries(): int
    {
        $value = abs($this->tries);

        return $value > 0 ? $value : 5;
    }

    public function getUnique(): Unique
    {
        return Queues\Unique::make($this->unique);
    }
}
