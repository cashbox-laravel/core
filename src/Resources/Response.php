<?php

namespace Helldar\Cashier\Resources;

use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Helpers\Ables\Arrayable;
use Illuminate\Contracts\Support\Arrayable as ArrayableContract;
use Illuminate\Support\Arr;

/**
 * @method static Response make(array $items = [], bool $mapping = true)
 */
abstract class Response implements ArrayableContract
{
    use Makeable;

    public const KEY_PAYMENT_ID = 'payment_id';

    public const KEY_STATUS = 'status';

    protected $map = [];

    protected $items = [];

    public function __construct(array $items = [], bool $mapping = true)
    {
        $mapping
            ? $this->map($items)
            : $this->set($items);
    }

    public function paymentId(): ?string
    {
        return $this->value(self::KEY_PAYMENT_ID);
    }

    public function getStatus(): ?string
    {
        return $this->value(self::KEY_STATUS);
    }

    public function toArray(): array
    {
        return Arrayable::of($this->items)
            ->except(self::KEY_PAYMENT_ID)
            ->filter()
            ->get();
    }

    public function put(string $key, $value, bool $mapping = true): self
    {
        if ($mapping) {
            $key = Arr::get($this->map, $key, $key);
        }

        Arr::set($this->items, $key, $value);

        return $this;
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

    protected function set(array $items): void
    {
        $this->items = $items;
    }
}
