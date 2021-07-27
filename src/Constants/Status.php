<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Constants;

class Status
{
    public const NEW = 'new';

    public const SUCCESS = 'success';

    public const FAILED = 'failed';

    public const REFUND = 'refund';

    public const WAIT_REFUND = 'wait_refund';
}
