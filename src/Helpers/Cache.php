<?php

namespace Helldar\Cashier\Helpers;

use Helldar\CashierDriver\Tinkoff\Auth\DTO\AccessToken;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache as Repository;

class Cache
{
    protected $divider = '::';

    public function get(Arrayable $instance, callable $request)
    {
        $key = $this->keys($instance);

        if (! $this->has($key)) {
            $response = $this->request($instance, $request);

            $this->set($key, $response);

            return $response->toArray();
        }
    }

    protected function has(string $key): bool
    {
        return Repository::has($key);
    }

    protected function from(string $key): array
    {
        $cache = Repository::get($key);

        return AccessToken::make($cache)->toArray();
    }

    protected function request($instance, callable $request): AccessToken
    {
        return $request($instance);
    }

    protected function key(Arrayable $instance): string
    {
        $basename = $this->basename($instance);
        $keys     = $this->keys($instance);

        return $basename . $this->divider . $keys;
    }

    protected function basename(Arrayable $instance): string
    {
        return get_class($client);
    }

    protected function keys(Arrayable $instance): string
    {
        return Collection::make($instance->toArray())
            ->map(static function ($item) {
                return md5((string) $item);
            })->implode($this->divider);
    }
}
