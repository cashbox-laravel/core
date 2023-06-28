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

use CashierProvider\Core\Models\Details;
use CashierProvider\Core\Services\Job;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('cashier:verify')]
class Verify extends Base
{
    protected $signature = 'cashier:verify';

    protected $description = 'Verifies the status of a bank transaction';

    protected int $delay = 59;

    public function handle(): void
    {
        $this->components->task('Cleaning', fn () => $this->clean());
        $this->components->task('Verifying', fn () => $this->process());
    }

    protected function getStatuses(): array
    {
        return $this->statuses()->inProgress();
    }

    protected function clean(): void
    {
        Details::query()
            ->whereDoesntHaveMorph('parent', $this->model())
            ->delete();
    }

    protected function process(): void
    {
        $this->payments(fn (Collection $items) => $items->each(
            fn (Model $payment) => $this->verify($payment)
        ));
    }

    protected function verify(Model $payment): void
    {
        if (! $this->isToday($payment) && $this->wasSent($payment)) {
            return;
        }

        Job::model($payment)->verify();

        $this->makeSent($payment);
    }

    protected function wasSent(Model $payment): bool
    {
        return $this->cache($payment)->has();
    }

    protected function makeSent(Model $payment): void
    {
        $this->cache($payment)->ttl($this->delay)->put(1);
    }

    protected function isToday(Model $payment): bool
    {
        return $payment->getAttribute(
            $this->attributeCreatedAt()
        )->isToday();
    }
}
