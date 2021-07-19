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

    public const KEY_PAYMENT_ID = 'payment_id';

    public const KEY_STATUS = 'status';

    protected $map = [];

    protected $items = [];

    public function __construct(array $items = [])
    {
        $this->map($items);
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
        return Arr::except($this->items, self::KEY_PAYMENT_ID);
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
