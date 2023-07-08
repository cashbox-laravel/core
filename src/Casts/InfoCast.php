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

namespace CashierProvider\Core\Casts;

use CashierProvider\Core\Concerns\Config\Payment\Drivers;
use CashierProvider\Core\Data\Models\InfoData;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class InfoCast implements CastsAttributes
{
    use Drivers;

    public function get(Model $model, string $key, mixed $value, array $attributes): InfoData
    {
        $instance = static::driverByModel($model->parent)->details;

        return call_user_func([$instance, 'from'], json_decode($value, true));
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  \Spatie\LaravelData\Data  $value
     * @param  array  $attributes
     *
     * @return string
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        return $value->toJson(JSON_UNESCAPED_SLASHES ^ JSON_UNESCAPED_UNICODE);
    }
}
