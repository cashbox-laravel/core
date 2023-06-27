<?php

/**
 * This file is part of the "cashier-provider/core" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider
 */

declare(strict_types=1);

namespace CashierProvider\Core\Concerns;

use CashierProvider\Core\Models\CashierDetail;
use Illuminate\Database\Eloquent\Model;

trait Relations
{
    protected function resolvePayment(CashierDetail $detail): void
    {
        if (empty($detail->parent)) {
            $parent = $detail->parent()->first();

            $detail->setRelation('parent', $parent);
        }
    }

    /**
     * @param \CashierProvider\Core\Concerns\Casheable|\Illuminate\Database\Eloquent\Model $payment
     */
    protected function resolveCashier(Model $payment): void
    {
        if (empty($payment->cashier)) {
            $cashier = $payment->cashier()->first();

            $payment->setRelation('cashier', $cashier);
        }
    }
}
