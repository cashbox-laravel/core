<?php

declare(strict_types=1);

namespace Tests\Fixtures\Models;

use CashierProvider\Core\Concerns\Casheable;
use DragonCode\LaravelSupport\Eloquent\UuidModel;
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
class ReadyPayment extends UuidModel
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

    protected function getStatusIdAttribute(): int
    {
        return TestCase::MODEL_STATUS_ID;
    }

    protected function getSumAttribute(): float
    {
        return TestCase::PAYMENT_SUM;
    }

    protected function getCurrencyAttribute(): int
    {
        return TestCase::CURRENCY;
    }

    protected function getCreatedAtAttribute(): Carbon
    {
        return Carbon::parse(TestCase::PAYMENT_DATE);
    }
}
