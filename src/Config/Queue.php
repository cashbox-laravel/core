<?php

declare(strict_types=1);

namespace Helldar\Cashier\Config;

use Helldar\Contracts\Cashier\Config\Queue as QueueContract;
use Helldar\SimpleDataTransferObject\DataTransferObject;

class Queue extends DataTransferObject implements QueueContract
{
    protected $connection;

    protected $name;

    public function getConnection(): ?string
    {
        return $this->connection;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
