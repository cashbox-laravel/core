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

namespace Helldar\Cashier\Resources;

use Helldar\Contracts\Cashier\Resources\Response as ResponseContract;
use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Helpers\Ables\Arrayable;
use Illuminate\Support\Arr;

/**
 * @method static Response make(array $items = [], bool $mapping = true)
 */
abstract class Response implements ResponseContract
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

    public function getPaymentId(): ?string
    {
        return $this->value(self::KEY_PAYMENT_ID);
    }

    public function getStatus(): ?string
    {
        return $this->value(self::KEY_STATUS);
    }

    public function toArray(): array
    {
        $keys = $this->keys();

        return Arrayable::of($this->items)
            ->except(self::KEY_PAYMENT_ID)
            ->filter(function (string $key) use ($keys) {
                return in_array($key, $keys, true);
            }, ARRAY_FILTER_USE_KEY)
            ->filter()
            ->get();
    }

    public function put(string $key, $value): self
    {
        $key = Arr::get($this->flipMap(), $key, $key);

        Arr::set($this->items, $key, $value);

        return $this;
    }

    protected function value(string $key)
    {
        return Arr::get($this->items, $key);
    }

    protected function map(array $items): void
    {
        $items = Arrayable::of($items)
            ->renameKeysMap($this->flipMap())
            ->get();

        $this->set($items);
    }

    protected function set(array $items): void
    {
        $this->items = $items;
    }

    protected function keys(): array
    {
        return array_keys($this->map);
    }

    protected function flipMap(): array
    {
        return array_flip($this->map);
    }
}
