<?php

/**
 * This file is part of the "cashier-provider/core" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider
 */

declare(strict_types=1);

namespace CashierProvider\Core\Concerns\Enums;

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

    public static function tryFrom(int|string $value): ?static
    {
        foreach (static::cases() as $case) {
            if ($case->name === $case || $case->value === $case) {
                return $case;
            }
        }

        return null;
    }
}
