<?php

declare(strict_types=1);

namespace CashierProvider\Core\Concerns\Enums;

use BackedEnum;
use CashierProvider\Core\Exceptions\Runtime\UnknownEnumValueException;

trait From
{
    public static function from(int|string $value): static
    {
        foreach (static::cases() as $case) {
            if (static::isSame($case, $value)) {
                return $case;
            }
        }

        throw new UnknownEnumValueException($value);
    }

    protected static function isSame(BackedEnum $case, mixed $value): bool
    {
        return $case->name === $value || $case->value === $value;
    }
}
