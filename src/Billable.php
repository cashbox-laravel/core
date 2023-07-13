<?php

/**
 * This file is part of the "cashbox/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashbox/foundation
 */

declare(strict_types=1);

namespace CashierProvider\Core;

use CashierProvider\Core\Models\Details;
use CashierProvider\Core\Services\Driver;
use CashierProvider\Core\Services\DriverManager;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @property Details $cashier
 */
trait Billable
{
    public function cashier(): Relation
    {
        return $this->hasOne(Details::class, 'payment_id', $this->getKeyName());
    }

    public function cashierDriver(): Driver
    {
        return DriverManager::find($this);
    }
}
