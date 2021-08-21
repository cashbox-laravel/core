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

namespace Helldar\Cashier\Config;

use Helldar\Contracts\Cashier\Config\Queue as QueueContract;
use Helldar\SimpleDataTransferObject\DataTransferObject;

class Queue extends DataTransferObject implements QueueContract
{
    protected $connection;

    protected $name;

    protected $after_commit = false;

    public function getConnection(): ?string
    {
        return $this->connection;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function afterCommit(): bool
    {
        return $this->after_commit;
    }
}
