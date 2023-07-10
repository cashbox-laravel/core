<?php

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
