<?php

/*
 * This file is part of the "andrey-helldar/cashier" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/cashier
 */

declare(strict_types=1);

namespace Helldar\Cashier\Helpers;

use Helldar\Cashier\Exceptions\Http\BadRequestClientException;
use Helldar\Contracts\Cashier\Exceptions\ExceptionManager as Contract;
use Helldar\Contracts\Http\Builder;
use Helldar\Support\Facades\Helpers\Arr;
use Throwable;

abstract class ExceptionManager implements Contract
{
    protected static $codes = [];

    protected static $default = BadRequestClientException::class;

    public static function throw(Throwable $e, Builder $uri): void
    {
        $exception = self::get($e->getCode());

        throw new $exception($uri);
    }

    protected static function get($code): string
    {
        return Arr::get(self::$codes, $code, self::$default);
    }
}
