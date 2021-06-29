<?php

namespace Helldar\Cashier\Resources;

use Helldar\Support\Concerns\Makeable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

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
        $this->map($items);
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

    protected function map(array $items): void
    {
        foreach ($this->map as $new => $old) {
            $value = Arr::get($items, $old);

            Arr::set($this->items, $new, $value);
        }
    }
}
