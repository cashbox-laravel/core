<?php

declare(strict_types=1);

namespace Cashbox\Core\Resources;

use Cashbox\Core\Concerns\Config\Payment\Attributes;
use Cashbox\Core\Enums\CurrencyEnum;
use Illuminate\Database\Eloquent\Model;

abstract class Resource
{
    use Attributes;

    protected CurrencyEnum $currency = CurrencyEnum::USD;

    public function __construct(
        protected Model $payment
    ) {}

    public function paymentId(): string
    {
        return (string) $this->payment->getKey();
    }

    public function status(): mixed
    {
        return $this->payment->getAttribute(
            static::attribute()->status
        );
    }

    public function sum(): int
    {
        return $this->payment->getAttribute(
            static::attribute()->sum
        );
    }

    public function currency(): CurrencyEnum
    {
        $value = $this->payment->getAttribute(
            static::attribute()->currency
        );

        return CurrencyEnum::tryFrom($value) ?? $this->currency;
    }
}
