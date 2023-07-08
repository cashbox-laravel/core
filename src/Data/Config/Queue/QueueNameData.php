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

namespace CashierProvider\Core\Data\Config\Queue;

use CashierProvider\Core\Data\Casts\FromEnumCast;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class QueueNameData extends Data
{
    #[WithCast(FromEnumCast::class)]
    public ?string $start;

    #[WithCast(FromEnumCast::class)]
    public ?string $verify;

    #[WithCast(FromEnumCast::class)]
    public ?string $refund;
}
