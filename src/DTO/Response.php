<?php

namespace Helldar\Cashier\DTO;

use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Helpers\Arr;
use Illuminate\Contracts\Support\Arrayable;

class Response implements Arrayable
{
    use Makeable;

    protected $map = [];

    protected $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $this->map($items);
    }

    public function toArray(): array
    {
        return $this->items;
    }

    public function __get($name)
    {
        return $this->items[$name];
    }

    protected function map(array $items): array
    {
        return Arr::renameKeysMap($items, $this->map);
    }
}
