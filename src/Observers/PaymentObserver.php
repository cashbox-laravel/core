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

namespace CashierProvider\Core\Observers;

use Illuminate\Database\Eloquent\Model;

class PaymentObserver
{
    public function created(Model $payment): void {}

    public function updated(Model $payment): void {}

    public function deleted(Model $payment): void {}

    public function restored(Model $payment): void {}

    public function forceDeleted(Model $payment): void {}
}
