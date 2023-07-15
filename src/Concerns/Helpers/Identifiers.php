<?php

declare(strict_types=1);

namespace Cashbox\Core\Concerns\Helpers;

use Illuminate\Support\Str;

trait Identifiers
{
    protected static function uuid(): string
    {
        return Str::uuid()->toString();
    }
}
