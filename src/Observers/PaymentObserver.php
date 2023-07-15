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

namespace Cashbox\Core\Observers;

use Cashbox\Core\Concerns\Config\Payment\Attributes;
use Cashbox\Core\Concerns\Events\Notifiable;
use Cashbox\Core\Concerns\Helpers\Jobs;
use Cashbox\Core\Concerns\Permissions\Allowable;
use DragonCode\Support\Facades\Helpers\Arr;
use Illuminate\Database\Eloquent\Model;

class PaymentObserver
{
    use Allowable;
    use Attributes;
    use Jobs;
    use Notifiable;

    public function created(Model $payment): void
    {
        if ($this->authorizeType($payment)) {
            static::job($payment)->start();
        }
    }

    public function updated(Model $payment): void
    {
        if (! $this->authorizeType($payment)) {
            return;
        }

        if ($this->wasChanged($payment)) {
            static::job($payment)->verify();
        }

        if ($this->wasChangedStatus($payment)) {
            static::eventWithDetect($payment);
        }
    }

    public function restored(Model $payment): void
    {
        if ($this->authorizeType($payment)) {
            static::job($payment)->retry();
        }
    }

    protected function wasChangedStatus(Model $payment): bool
    {
        return $payment->wasChanged(
            static::attribute()->status
        );
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
