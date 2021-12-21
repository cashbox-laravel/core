<?php

/*
 * This file is part of the "cashier-provider/core" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/cashier-provider/core
 */

declare(strict_types=1);

namespace CashierProvider\Core\Console\Commands;

use CashierProvider\Core\Models\CashierDetail;
use CashierProvider\Core\Services\Jobs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Check extends Base
{
    protected $signature = 'cashier:check';

    protected $description = 'Launching a re-verification of payments with a long processing cycle';

    public function handle()
    {
        $this->cleanup();
        $this->checkPayments();
    }

    protected function cleanup(): void
    {
        CashierDetail::query()
            ->whereDoesntHaveMorph('parent', $this->model())
            ->delete();
    }

    protected function checkPayments(): void
    {
        $this->payments()->chunk($this->count, function (Collection $payments) {
            $payments->each(function (Model $payment) {
                $this->check($payment);
            });
        });
    }

    protected function check(Model $model): void
    {
        Jobs::make($model)->check(true);
    }
}
