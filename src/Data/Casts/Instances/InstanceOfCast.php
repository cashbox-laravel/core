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

namespace Cashbox\Core\Data\Casts\Instances;

use Cashbox\Core\Services\Validator;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class InstanceOfCast implements Cast
{
    public function __construct(
        protected readonly string $needle,
        protected readonly string $exception
    ) {}

    public function cast(DataProperty $property, mixed $value, array $context): string
    {
        return Validator::validate($value, $this->needle, $this->exception);
    }
}
