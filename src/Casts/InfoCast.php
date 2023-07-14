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

namespace Cashbox\Core\Casts;

use Cashbox\Core\Concerns\Config\Application;
use Cashbox\Core\Http\ResponseInfo;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class InfoCast implements CastsAttributes
{
    use Application;

    public function get(Model $model, string $key, mixed $value, array $attributes): ResponseInfo
    {
        $instance = $model->parent->cashboxDriver()->info;

        return call_user_func([$instance, 'from'], json_decode($value, true));
    }

    /**
     * @param  \Spatie\LaravelData\Data  $value
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        return $value->toJson($this->flags());
    }

    protected function flags(): int
    {
        return static::isProduction()
            ? JSON_UNESCAPED_SLASHES ^ JSON_UNESCAPED_UNICODE ^ JSON_NUMERIC_CHECK
            : JSON_UNESCAPED_SLASHES ^ JSON_UNESCAPED_UNICODE ^ JSON_NUMERIC_CHECK ^ JSON_PRETTY_PRINT;
    }
}
