<?php

/**
 * This file is part of the "cashier-provider/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider/foundation
 */

declare(strict_types=1);

namespace CashierProvider\Core\Observers;

use CashierProvider\Core\Concerns\Config\Payment\Attributes;
use CashierProvider\Core\Concerns\Permissions\Allowable;
use CashierProvider\Core\Services\Job;
use DragonCode\Support\Facades\Helpers\Arr;
use Illuminate\Database\Eloquent\Model;

class PaymentObserver
{
    use Attributes;
    use Allowable;

    public function created(Model $payment): void
    {
        Job::model($payment)->start();
    }

    public function updated(Model $payment): void
    {
        if ($this->wasChanged($payment)) {
            Job::model($payment)->verify();
        }
    }

    protected function wasChanged(Model $payment): bool
    {
        return $payment->wasChanged(
            $this->exceptFields($payment)
        );
    }

    protected function exceptFields(Model $payment): array
    {
        return Arr::of($payment->getChanges())->except([
            static::attribute()->status,
            static::attribute()->createdAt,
        ])->keys()->toArray();
    }
}
