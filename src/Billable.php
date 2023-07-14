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
 * @see https://github.com/cashbox-laravel/foundation
 */

declare(strict_types=1);

namespace Cashbox\Core;

use Cashbox\Core\Models\Details;
use Cashbox\Core\Services\Driver;
use Cashbox\Core\Services\DriverManager;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @property Details $cashbox
 */
trait Billable
{
    public function cashbox(): Relation
    {
        return $this->hasOne(Details::class, 'payment_id', $this->getKeyName());
    }

    public function cashboxDriver(): Driver
    {
        return DriverManager::find($this);
    }
}
