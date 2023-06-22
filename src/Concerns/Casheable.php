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

use CashierProvider\Core\Facades\DriverManager;
use CashierProvider\Core\Models\CashierDetail;
use CashierProvider\Core\Services\Driver;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 *
 * @property \CashierProvider\Core\Models\CashierDetail $cashier
 */
trait Casheable
{
    use Attributes;

    /**
     * Relation to model with payment status.
     */
    public function cashier(): Relation
    {
        return $this->morphOne(CashierDetail::class, 'item');
    }

    public function cashierStatus(): mixed
    {
        return $this->getAttribute(
            $this->attributeStatus()
        );
    }

    public function cashierType(): mixed
    {
        return $this->getAttribute(
            $this->attributeType()
        );
    }

    public function cashierDriver(): Driver
    {
        return DriverManager::fromModel($this);
    }
}
