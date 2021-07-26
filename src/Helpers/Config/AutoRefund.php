<?php

namespace Helldar\Cashier\Helpers\Config;

class AutoRefund extends Base
{
    public function enabled(): bool
    {
        return config('cashier.auto_refund.enabled');
    }

    public function delay(): int
    {
        $value = config('cashier.auto_refund.delay');

        return $this->moduleValue($value);
    }
}
