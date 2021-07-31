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

namespace Helldar\Cashier\Concerns;

use Helldar\Cashier\Models\CashierDetail;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 *
 * @property \Helldar\Cashier\Models\CashierDetail $cashier
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
}
