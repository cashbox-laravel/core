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

use Carbon\Carbon;
use CashierProvider\Core\Facades\Config;
use CashierProvider\Core\Services\Job;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('cashier:refund')]
class Refund extends Base
{
    protected $signature = 'cashier:refund';

    protected $description = 'Launching the command to check payments for refunds';

    public function handle(): void
    {
        $this->payments()->chunkById($this->chunk, fn (Collection $payments) => $payments->each(
            fn (Model $payment) => $this->cancel($payment)
        ));
    }

    protected function getStatuses(): array
    {
        return Config::payment()->status->allowToRefund();
    }

    protected function getCreatedAt(): ?Carbon
    {
        return now()->subMinutes(
            Config::refund()->delay
        );
    }

    public function isEnabled(): bool
    {
        return Config::refund()->enabled;
    }

    protected function cancel(Model $payment): void
    {
        Job::make($payment)->refund();
    }
}
