<?php

declare(strict_types=1);

namespace Helldar\Cashier\Concerns;

use Helldar\Cashier\Models\CashierDetail;

trait Relations
{
    protected function resolvePayment(CashierDetail $detail): void
    {
        if (empty($detail->parent)) {
            $parent = $detail->parent()->first();

            $detail->setRelation('parent', $parent);
        }
    }
}
