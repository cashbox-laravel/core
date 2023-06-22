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

namespace CashierProvider\Core\Casts\Eloquent;

use CashierProvider\Core\Resources\Details;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

use function json_decode;

class DetailsCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?Details
    {
        return $model->parent->cashierDriver()->details(
            json_decode($value)
        );
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        return $value?->toJson();
    }
}
