<?php

namespace Helldar\Cashier\Concerns;

trait Resolvable
{
    protected static $resolved = [];

    protected function resolve(string $value, callable $callback)
    {
        $class = static::class;

        if (isset(static::$resolved[$class][$value])) {
            return static::$resolved[$class][$value];
        }

        return static::$resolved[$class][$value] = $callback($value);
    }
}
