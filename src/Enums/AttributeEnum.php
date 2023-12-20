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
 * @see https://cashbox.city
 */

declare(strict_types=1);

namespace Cashbox\Core\Enums;

use ArchTech\Enums\InvokableCases;

/**
 * @method static string CreatedAt()
 * @method static string Status()
 * @method static string Type()
 */
enum AttributeEnum: string
{
    use InvokableCases;

    case CreatedAt = 'created_at';
    case Status    = 'status';
    case Type      = 'type';
}
