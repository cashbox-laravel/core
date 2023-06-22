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
 * @method int failed()
 * @method int new()
 * @method int refund()
 * @method int success()
 * @method int waitRefund()
 */
enum Status: int
{
    use Values;

    case new        = 0;
    case success    = 1;
    case waitRefund = 2;
    case refund     = 3;
    case failed     = 4;
}
