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

namespace CashierProvider\Core\Casts\Data;

use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class LogChannelCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): LoggerInterface
    {
        return Log::channel($value);
    }
}
