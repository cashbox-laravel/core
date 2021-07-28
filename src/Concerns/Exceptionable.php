<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Concerns;

/**
 * @property int $default_status_code
 */
trait Exceptionable
{
    protected $status_code;

    protected $reason;

    public function getStatus(): int
    {
        return $this->status_code ?: $this->getDefaultStatusCode();
    }

    public function getReason(...$values): string
    {
        return sprintf($this->reason, ...$values);
    }

    protected function getDefaultStatusCode(): int
    {
        return $this->default_status_code ?? 500;
    }
}
