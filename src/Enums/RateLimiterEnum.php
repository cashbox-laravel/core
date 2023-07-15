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

namespace Cashbox\Core\Enums;

use ArchTech\Enums\InvokableCases;

/**
 * @method static string disabled()
 * @method static string enabled()
 */
enum RateLimiterEnum: string
{
    use InvokableCases;

    case disabled = 'cashbox_disabled';
    case enabled  = 'cashbox_enabled';
}
