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

namespace CashierProvider\Core\Services;

use CashierProvider\Core\Billable;
use CashierProvider\Core\Exceptions\Internal\IncorrectPaymentModelException;
use DragonCode\Support\Facades\Instances\Instance;
use Illuminate\Database\Eloquent\Model;

class Validator
{
    public static function model(Model|string $payment): Model|string
    {
        return static::validate($payment, Billable::class, IncorrectPaymentModelException::class);
    }

    protected static function validate(mixed $haystack, string $needle, string $exception): mixed
    {
        if (! Instance::of($haystack, $needle)) {
            throw new $exception($haystack, $needle);
        }

        return $haystack;
    }
}
