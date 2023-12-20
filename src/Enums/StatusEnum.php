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
use ArchTech\Enums\Values;
use Cashbox\Core\Concerns\Enums\From;

/**
 * @method string Failed()
 * @method string New()
 * @method string Refund()
 * @method string Success()
 * @method string WaitRefund()
 */
enum StatusEnum: string
{
    use From;
    use InvokableCases;
    use Values;

    case Failed     = 'failed';
    case New        = 'new';
    case Refund     = 'refund';
    case Success    = 'success';
    case WaitRefund = 'wait_refund';
}
