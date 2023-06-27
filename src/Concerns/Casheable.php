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
use CashierProvider\Core\Models\CashierLog;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 *
 * @property \CashierProvider\Core\Models\CashierDetail $cashier
 */
trait Casheable
{
    /**
     * Relation to model with payment status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function cashier(): MorphOne
    {
        return $this->morphOne(CashierDetail::class, 'item');
    }

    /**
     * Relation to model with HTTP logs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function cashierLogs(): MorphMany
    {
        return $this->morphMany(CashierLog::class, 'item');
    }
}
