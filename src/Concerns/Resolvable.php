<?php

namespace Helldar\Cashier\Concerns;

trait Resolvable
{
    protected static $resolved = [];

    protected function resolve(string $id, callable $callback)
    {
        $class = static::class;

        if (isset(static::$resolved[$class][$id])) {
            return static::$resolved[$class][$id];
        }

        return static::$resolved[$class][$id] = $callback($id);
    }
}
