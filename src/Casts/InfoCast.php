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

declare(strict_types=1);

namespace CashierProvider\Core\Casts;

use CashierProvider\Core\Concerns\Config\Application;
use CashierProvider\Core\Http\Response;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class InfoCast implements CastsAttributes
{
    use Application;

    public function get(Model $model, string $key, mixed $value, array $attributes): Response
    {
        $instance = $model->parent->cashierDriver()->info;

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
