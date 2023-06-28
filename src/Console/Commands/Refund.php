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

namespace CashierProvider\Core\Console\Commands;

use CashierProvider\Core\Services\Job;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('cashier:refund')]
class Refund extends Base
{
    protected $signature = 'cashier:refund';

    protected $description = 'Refunds all payment transactions';

    public function handle(): void
    {
        $this->components->task('Refunding', fn () => $this->process());
    }

    protected function getStatuses(): array
    {
        return $this->statuses()->toRefund();
    }

    protected function process(): void
    {
        $this->payments(fn (Collection $items) => $items->each(
            fn (Model $payment) => $this->refund($payment)
        ));
    }

    protected function refund(Model $payment): void
    {
        Job::model($payment)->refund();
    }
}
