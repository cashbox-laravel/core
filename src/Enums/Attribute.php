<?php

declare(strict_types=1);

namespace CashierProvider\Core\Enums;

use ArchTech\Enums\Values;

/**
 * @method string createdAt()
 * @method string status()
 * @method string type()
 */
enum Attribute: string
{
    use Values;

    case type      = 'type';
    case status    = 'status';
    case createdAt = 'created_at';
}
