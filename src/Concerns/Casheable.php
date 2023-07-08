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

use CashierProvider\Core\Helpers\DriverManager;
use CashierProvider\Core\Models\Details;
use CashierProvider\Core\Services\Driver;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait Casheable
{
    public function cashier(): MorphOne
    {
        return $this->morphOne(Details::class, 'item');
    }

    // main trait
    public function cashierDriver(): Driver
    {
        return DriverManager::find($this);
    }
}
