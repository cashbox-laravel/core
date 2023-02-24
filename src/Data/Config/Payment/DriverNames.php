<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config\Payment;

use Illuminate\Support\Arr;
use Spatie\LaravelData\Data;

class DriverNames extends Data
{
    protected array $items;

    public static function from(...$payloads): static
    {
        return parent::from(['items' => $payloads]);
    }

    public function types(): array
    {
        return array_keys($this->items);
    }

    public function names(): array
    {
        return array_values($this->items);
    }

    public function get(string|int $type): string|int
    {
        return Arr::get($this->items, $type);
    }
}
