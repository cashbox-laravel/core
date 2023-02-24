<?php

declare(strict_types=1);

namespace CashierProvider\Core\Concerns\Enums;

use CashierProvider\Core\Exceptions\Runtime\UnknownEnumValueException;

trait From
{
    public static function from(string|int $value): static
    {
        foreach (static::cases() as $case) {
            if ($case->name === $case || $case->value === $case) {
                return $case;
            }
        }

        throw new UnknownEnumValueException($value);
    }
}
