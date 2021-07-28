<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Config\Payments;

use Helldar\Contracts\Cashier\Config\Payments\Map as MapContract;
use Helldar\SimpleDataTransferObject\DataTransferObject;
use Helldar\Support\Facades\Helpers\Arr;

class Map extends DataTransferObject implements MapContract
{
    protected $drivers = [];

    public function getAll(): array
    {
        return $this->drivers;
    }

    public function getTypes(): array
    {
        return array_keys($this->drivers);
    }

    public function getNames(): array
    {
        return array_values($this->drivers);
    }

    public function get(string $type): string
    {
        return Arr::get($this->getAll(), $type);
    }
}
