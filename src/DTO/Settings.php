<?php

declare(strict_types=1);

namespace Helldar\Cashier\DTO;

use Helldar\Cashier\Exceptions\MethodNotAllowedException;
use Helldar\Cashier\Exceptions\UnknownPropertyException;
use Helldar\Support\Facades\Helpers\Ables\Arrayable;
use Helldar\Support\Facades\Helpers\Ables\Stringable;
use Helldar\Support\Facades\Helpers\Str;
use Illuminate\Contracts\Support\Arrayable as ArrayableContract;
use Illuminate\Support\Arr;

/**
 * @method string|null getClientId()
 * @method string|null getClientSecret()
 * @method string|null getPaymentId()
 * @method string|null getTerminalId()
 */
class Settings implements ArrayableContract
{
    protected $values = [
        'client_id'     => null,
        'client_secret' => null,
        'terminal_id'   => null,
        'payment_id'    => null,
    ];

    public function __construct(array $values)
    {
        foreach ($values as $key => $value) {
            if ($this->has($key)) {
                $this->set($key, $value);
            }
        }
    }

    public function __call(string $name, $arguments = null)
    {
        if (! $this->allow($name)) {
            throw new MethodNotAllowedException($name);
        }

        $key = $this->resolveKeyName($name);

        if ($this->has($key)) {
            return $this->get($key);
        }

        throw new UnknownPropertyException($key);
    }

    public function toArray(): array
    {
        return Arrayable::of($this->values)
            ->filter()
            ->get();
    }

    protected function resolveKeyName(string $name): string
    {
        return Stringable::of($name)->after('get')->snake();
    }

    protected function has(string $key): bool
    {
        return Arr::has($this->values, $key);
    }

    protected function get(string $key)
    {
        return Arr::get($this->values, $key);
    }

    protected function set(string $key, $value): void
    {
        Arr::set($this->values, $key, $value);
    }

    protected function allow(string $method): bool
    {
        return Str::startsWith($method, 'get');
    }
}
