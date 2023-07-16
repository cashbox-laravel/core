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

namespace Cashbox\Core\Console\Commands;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('cashier:verify')]
class Verify extends Command
{
    protected $signature = 'cashier:verify {paymentId?} {--force}';

    protected $description = 'Verifies the status of a bank transaction';

    protected function getStatuses(): array
    {
        return static::statuses()->inProgress();
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\Cashbox\Core\Billable  $payment
     *
     * @return void
     */
    protected function process(Model $payment): void
    {
        $payment->cashboxJob($this->hasForce())->verify();
    }
}
