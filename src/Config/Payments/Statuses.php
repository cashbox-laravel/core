<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Config\Payments;

use Helldar\Contracts\Cashier\Config\Payments\Statuses as StatusesContract;
use Helldar\SimpleDataTransferObject\DataTransferObject;
use Helldar\Support\Facades\Helpers\Arr;

class Statuses extends DataTransferObject implements StatusesContract
{
    protected $statuses = [];

    public function getAll(): array
    {
        return $this->statuses;
    }

    public function getStatus(string $status)
    {
        return Arr::get($this->statuses, $status);
    }
}
