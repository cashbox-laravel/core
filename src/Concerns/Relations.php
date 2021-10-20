<?php

/*
 * This file is part of the "andrey-helldar/cashier" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/cashier
 */

declare(strict_types=1);

namespace CashierProvider\Manager\Concerns;

use CashierProvider\Manager\Models\CashierDetail;
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
     * @param  \CashierProvider\Manager\Concerns\Casheable|\Illuminate\Database\Eloquent\Model  $payment
     */
    protected function resolveCashier(Model $payment): void
    {
        if (empty($payment->cashier)) {
            $cashier = $payment->cashier()->first();

            $payment->setRelation('cashier', $cashier);
        }
    }
}
