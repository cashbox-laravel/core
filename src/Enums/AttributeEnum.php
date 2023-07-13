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
 * @see https://github.com/cashbox/foundation
 */

declare(strict_types=1);

namespace CashierProvider\Core\Enums;

use ArchTech\Enums\InvokableCases;

/**
 * @method static string createdAt()
 * @method static string status()
 * @method static string type()
 */
enum AttributeEnum: string
{
    use InvokableCases;

    case createdAt = 'created_at';
    case status    = 'status';
    case type      = 'type';
}
