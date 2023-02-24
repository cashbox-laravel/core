<?php

declare(strict_types=1);

namespace CashierProvider\Core\Enums;

use CashierProvider\Core\Constants\Status as SC;

enum Status: string
{
    case failed = SC::FAILED;
    case new = SC::NEW;
    case refund = SC::REFUND;
    case success = SC::SUCCESS;
    case waitRefund = SC::WAIT_REFUND;
}
