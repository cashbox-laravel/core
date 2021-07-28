<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Helpers;

use Ramsey\Uuid\Uuid;

class Unique
{
    protected $value;

    public function id(bool $unique = true): string
    {
        if (! $unique && $this->value) {
            return $this->value;
        }

        return $this->value = $this->hash();
    }

    protected function hash(): string
    {
        return md5($this->uuid());
    }

    protected function uuid(): string
    {
        return Uuid::uuid4()->toString();
    }
}
