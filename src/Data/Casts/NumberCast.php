<?php

/**
 * This file is part of the "cashier-provider/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider/foundation
 */

namespace CashierProvider\Core\Data\Casts;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class NumberCast implements Cast
{
    public function __construct(
        protected readonly int $min = 0,
        protected readonly int $default = 100
    ) {}

    public function cast(DataProperty $property, mixed $value, array $context): int
    {
        return $value >= $this->min ? (int) $value : $this->default;
    }
}
