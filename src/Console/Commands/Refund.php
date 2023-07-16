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

use Carbon\Carbon;
use Cashbox\Core\Concerns\Config\Refund as RefundConfig;
use Closure;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('cashbox:refund')]
class Refund extends Command
{
    use RefundConfig;

    protected $signature = 'cashbox:refund {payment?} {--force}';

    protected $description = 'Refunds all payment transactions';

    protected function condition(): ?Closure
    {
        if ($this->hasForce()) {
            return null;
        }

        return function (Builder $builder) {
            return $builder->where(static::attributeConfig()->createdAt, '<=', $this->createdBefore());
        };
    }

    protected function getStatuses(): array
    {
        return static::statusConfig()->toRefund();
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\Cashbox\Core\Billable  $payment
     */
    protected function process(Model $payment): void
    {
        $payment->cashboxJob($this->hasForce())->refund();
    }

    protected function createdBefore(): DateTimeInterface
    {
        return Carbon::now()->subSeconds(
            static::autoRefundConfig()->delay
        );
    }
}
