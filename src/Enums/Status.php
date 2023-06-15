<?php

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
