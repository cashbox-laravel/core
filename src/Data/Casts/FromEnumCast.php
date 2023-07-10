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

use CashierProvider\Core\Concerns\Transformers\EnumsTransformer;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class FromEnumCast implements Cast
{
    use EnumsTransformer;

    public function cast(DataProperty $property, mixed $value, array $context): ?string
    {
        if (! empty($value)) {
            return static::transformFromEnum($value);
        }

        return null;
    }
}
