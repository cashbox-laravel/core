<?php

/*
 * This file is part of the "cashier-provider/sber-qr" project.
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
 * @see https://github.com/cashier-provider/sber-qr
 */

namespace Tests\Fixtures\Models;

use CashierProvider\Core\Concerns\Casheable;
use Helldar\LaravelSupport\Eloquent\UuidModel;
use Illuminate\Support\Carbon;
use Tests\TestCase;

/**
 * @property \Illuminate\Support\Carbon $created_at
 * @property float $sum
 * @property int $currency
 * @property int $status_id
 * @property int $type_id
 * @property string $uuid;
 */
class StatusPayment extends UuidModel
{
    use Casheable;

    protected function getUuidAttribute(): string
    {
        return TestCase::PAYMENT_ID;
    }

    protected function getTypeIdAttribute(): int
    {
        return TestCase::MODEL_TYPE_ID;
    }

    protected function getSumAttribute(): float
    {
        return TestCase::PAYMENT_SUM;
    }

    protected function getCurrencyAttribute(): string
    {
        return TestCase::CURRENCY;
    }

    protected function getCreatedAtAttribute(): Carbon
    {
        return Carbon::parse(TestCase::PAYMENT_DATE);
    }
}
