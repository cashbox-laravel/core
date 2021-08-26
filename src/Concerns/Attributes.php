<?php

declare(strict_types=1);

namespace Helldar\Cashier\Concerns;

use Helldar\Cashier\Facades\Config\Payment;

trait Attributes
{
    public function attributeType(): string
    {
        return Payment::getAttributes()->getType();
    }

    public function attributeStatus(): string
    {
        return Payment::getAttributes()->getStatus();
    }

    public function attributeCreatedAt(): string
    {
        return Payment::getAttributes()->getCreatedAt();
    }
}
