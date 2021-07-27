<?php

declare(strict_types=1);

namespace Helldar\Cashier\Config;

use Helldar\Cashier\Config\Payments\Attributes;
use Helldar\Cashier\Config\Payments\Statuses;
use Helldar\Contracts\Cashier\Config\Payment as PaymentContract;
use Helldar\Contracts\Cashier\Config\Payments\Attributes as AttributesContract;
use Helldar\Contracts\Cashier\Config\Payments\Statuses as StatusesContract;

class Payment extends Base implements PaymentContract
{
    public function getModel(): string
    {
        return config('cashier.payment.model');
    }

    public function getAttributes(): AttributesContract
    {
        $values = config('cashier.payment.attributes');

        return Attributes::make($values);
    }

    public function getStatuses(): StatusesContract
    {
        $values = config('cashier.payment.statuses', []);

        return Statuses::make($values);
    }
}
