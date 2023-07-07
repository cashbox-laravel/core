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

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('cashier:refund')]
class Refund extends Command
{
    protected $signature = 'cashier:refund {--force}';

    protected $description = 'Refunds all payment transactions';

    public function handle(): void
    {
        $this->components->task('Refunding', fn () => $this->ran());
    }

    protected function getStatuses(): array
    {
        return $this->statuses()->toRefund();
    }

    protected function process(Model $payment): void
    {
        $this->job($payment)->refund();
    }
}
