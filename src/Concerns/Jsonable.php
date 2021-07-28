<?php

declare(strict_types=1);

namespace Helldar\Cashier\Concerns;

use Helldar\Cashier\Facades\Helpers\JSON;

/** @mixin \Helldar\Contracts\Support\Arrayable */
trait Jsonable
{
    public function toJson(int $options = 0): string
    {
        return JSON::encode($this->toArray());
    }
}
