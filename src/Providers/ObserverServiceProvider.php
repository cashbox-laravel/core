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
 * @see https://cashbox.city
 */

declare(strict_types=1);

namespace Cashbox\Core\Providers;

use Cashbox\Core\Models\Details;
use Cashbox\Core\Observers\PaymentDetailsObserver;
use Cashbox\Core\Observers\PaymentObserver;

class ObserverServiceProvider extends BaseProvider
{
    public function boot(): void
    {
        if ($this->disabled()) {
            return;
        }

        $this->bootPayment();
        $this->bootPaymentDetails();
    }

    protected function bootPayment(): void
    {
        $model = static::paymentConfig()->model;

        $model::observe(PaymentObserver::class);
    }

    protected function bootPaymentDetails(): void
    {
        Details::observe(PaymentDetailsObserver::class);
    }
}
