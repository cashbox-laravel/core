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

use CashierProvider\Core\Casts\Data\LogChannelCast;
use Psr\Log\LoggerInterface;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class LogsData extends Data
{
    public bool $enabled;

    #[WithCast(LogChannelCast::class)]
    public LoggerInterface $channel;
}
