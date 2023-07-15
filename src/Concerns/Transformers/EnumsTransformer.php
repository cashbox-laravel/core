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

namespace Cashbox\Core\Concerns\Transformers;

use BackedEnum;

trait EnumsTransformer
{
    protected static function transformFromEnum(int|string|BackedEnum $item): int|string
    {
        if ($item instanceof BackedEnum) {
            return $item->value ?? $item->name;
        }

        return $item;
    }
}
