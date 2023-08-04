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
 * @see https://cashbox.city
 */

declare(strict_types=1);

namespace Cashbox\Core\Services;

use DragonCode\Cache\Services\Cache;
use Illuminate\Support\Str;

class Identifier
{
    protected static int $ttl = 60;

    public static function getUnique(): string
    {
        return Str::uuid()->toString();
    }

    public static function getStatic(mixed $key): string
    {
        return Cache::make()->ttl(static::$ttl)->key(static::class, $key)->remember(
            fn () => static::getUnique()
        );
    }
}
