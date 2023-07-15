<?php

declare(strict_types=1);

namespace Cashbox\Core\Concerns\Repositories;

trait Registry
{
    protected array $registry = [];

    protected function resolve(string $class, mixed ...$parameters): mixed
    {
        if (isset($this->registry[$class])) {
            return $this->registry[$class];
        }

        return $this->registry[$class] = new $class(...$parameters);
    }
}
