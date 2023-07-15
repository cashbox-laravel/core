<?php

/**
 * This file is part of the "cashbox/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashbox-laravel/foundation
 */

declare(strict_types=1);

namespace Cashbox\Core\Concerns\Enums;

use BackedEnum;
use Illuminate\Support\Str;
use OutOfBoundsException;

trait From
{
    public static function from(int|string $value): static
    {
        if ($case = static::tryFrom($value)) {
            return $case;
        }

        throw new OutOfBoundsException($value);
    }

    public static function tryFrom(int|string|BackedEnum $value): ?static
    {
        if ($value instanceof static) {
            return $value;
        }

        $name  = static::resolveName($value);
        $value = static::resolveValue($value);

        foreach (static::cases() as $case) {
            if (static::prepareName($case->name) === static::prepareName($name) || $case->value === $value) {
                return $case;
            }
        }

        return null;
    }

    protected static function prepareName(int|string $name): string
    {
        return Str::lower((string) $name);
    }

    protected function resolveName(int|string|BackedEnum $item): string
    {
        if ($item instanceof BackedEnum) {
            return $item->name;
        }

        return (string) $item;
    }

    protected function resolveValue(int|string|BackedEnum $item): string
    {
        if ($item instanceof BackedEnum) {
            return $item->value;
        }

        return (string) $item;
    }
}
