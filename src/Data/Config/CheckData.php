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

namespace CashierProvider\Core\Data\Config;

use CashierProvider\Core\Casts\Data\NumberCast;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class CheckData extends Data
{
    #[WithCast(NumberCast::class, min: 0, default: 60)]
    public int $delay;

    #[WithCast(NumberCast::class, min: 0, default: 30)]
    public int $timeout;
}
