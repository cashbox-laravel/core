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

    abstract public function currency(): CurrencyEnum;

    abstract public function sum(): int;

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
}
