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

namespace CashierProvider\Core\Console\Commands;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('cashier:refund')]
class Refund extends Command
{
    protected $signature = 'cashier:refund {paymentId?} {--force}';

    protected $description = 'Refunds all payment transactions';

    protected function getStatuses(): array
    {
        return static::statuses()->toRefund();
    }

    protected function process(Model $payment): void
    {
        static::job($payment, $this->hasForce())->refund();
    }
}
