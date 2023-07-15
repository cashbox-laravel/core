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
use ArchTech\Enums\Values;
use Cashbox\Core\Concerns\Enums\From;

/**
 * @method string failed()
 * @method string new()
 * @method string refund()
 * @method string success()
 * @method string waitRefund()
 */
enum StatusEnum: string
{
    use From;
    use InvokableCases;
    use Values;

    case failed     = 'failed';
    case new        = 'new';
    case refund     = 'refund';
    case success    = 'success';
    case waitRefund = 'wait_refund';
}
