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

namespace CashierProvider\Core\Enums;

use ArchTech\Enums\Values;

/**
 * @method static string disabled()
 * @method static string hourly()
 */
enum RateLimiterEnum: string
{
    use Values;

    case disabled = 'disabled';
    case hourly   = 'hourly';
}
