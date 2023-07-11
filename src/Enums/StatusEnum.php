<?php

/**
 * This file is part of the "cashier-provider/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider/foundation
 */

declare(strict_types=1);

namespace CashierProvider\Core\Enums;

use ArchTech\Enums\InvokableCases;
use CashierProvider\Core\Concerns\Enums\From;

/**
 * @method string deleted()
 * @method string failed()
 * @method string new()
 * @method string refund()
 * @method string success()
 * @method string waitRefund()
 */
enum StatusEnum: string
{
    use InvokableCases;
    use From;

    case new        = 'new';
    case success    = 'success';
    case waitRefund = 'wait_refund';
    case refund     = 'refund';
    case failed     = 'failed';
    case deleted    = 'deleted';
}
