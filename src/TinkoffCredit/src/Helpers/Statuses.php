<?php

namespace CashierProvider\Tinkoff\Credit\Helpers;

use CashierProvider\Core\Services\Statuses as BaseStatus;

class Statuses extends BaseStatus
{
    public const NEW = [
        'NEW',
    ];

    public const REFUNDING = [];

    public const REFUNDED = [
        'CANCELED',
    ];

    public const FAILED = [
        'REJECTED',
    ];

    public const SUCCESS = [
        'APPROVED',
    ];
}
