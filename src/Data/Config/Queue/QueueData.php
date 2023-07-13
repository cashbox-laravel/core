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

namespace CashierProvider\Core\Data\Config\Queue;

use CashierProvider\Core\Data\Casts\NumberCast;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class QueueData extends Data
{
    public ?string $connection;

    #[WithCast(NumberCast::class, min: 1, max: 50)]
    public int $tries;

    #[WithCast(NumberCast::class, min: 1, max: 10)]
    public int $exceptions;

    public QueueNameData $name;
}
