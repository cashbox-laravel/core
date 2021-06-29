<?php

namespace Helldar\Cashier\Resources;

use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Helpers\Arr;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @method static Response make(array $items = [])
 */
abstract class Response implements Arrayable
{
    use Makeable;

    protected $map = [];

    protected $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $this->map($items);
    }

    public function paymentId(): ?string
    {
        return $this->value('payment_id');
    }

    public function getStatus(): ?string
    {
        return $this->value('status');
    }

    public function toArray(): array
    {
        return $this->items;
    }

    protected function value(string $key)
    {
        return Arr::get($this->items, $key);
    }

    protected function map(array $items): array
    {
        return Arr::renameKeysMap($items, $this->map);
    }
}
