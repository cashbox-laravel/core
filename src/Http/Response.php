<?php

/**
 * This file is part of the "cashier-provider/core" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider
 */

declare(strict_types=1);

namespace CashierProvider\Core\Http;

use DragonCode\Contracts\Cashier\Http\Response as ResponseContract;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Helpers\Arr as DragonArr;
use Illuminate\Support\Arr;

/**
 * @method static Response make(array $items = [], bool $mapping = true)
 */
abstract class Response implements ResponseContract
{
    use Makeable;

    public const KEY_EXTERNAL_ID  = 'external_id';
    public const KEY_OPERATION_ID = 'operation_id';
    public const KEY_STATUS       = 'status';

    protected $map = [];

    protected $items = [];

    public function __construct(array $items = [], bool $mapping = true)
    {
        $mapping
            ? $this->map($items)
            : $this->set($items);
    }

    public function isEmpty(): bool
    {
        return empty($this->getExternalId());
    }

    public function getExternalId(): ?string
    {
        $value = $this->value(self::KEY_EXTERNAL_ID);

        return ! empty($value) ? (string) $value : null;
    }

    public function getOperationId(): ?string
    {
        $value = $this->value(self::KEY_OPERATION_ID);

        return ! empty($value) ? (string) $value : null;
    }

    public function getStatus(): ?string
    {
        return $this->value(self::KEY_STATUS);
    }

    public function toArray(): array
    {
        $keys = $this->keys();

        return DragonArr::of($this->items)
            ->except(self::KEY_EXTERNAL_ID)
            ->filter(function ($value, string $key) use ($keys) {
                return in_array($key, $keys, true) && ! empty($value);
            }, ARRAY_FILTER_USE_BOTH)
            ->toArray();
    }

    public function put(string $key, $value): self
    {
        $key = Arr::get($this->flipMap(), $key, $key);

        $value = is_string($value) ? trim($value) : $value;

        Arr::set($this->items, $key, $value);

        return $this;
    }

    protected function value(string $key)
    {
        return Arr::get($this->items, $key);
    }

    protected function map(array $items): void
    {
        foreach ($this->map as $to => $from) {
            $value = Arr::get($items, $from);

            $this->put($to, $value);
        }
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
