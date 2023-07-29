<?php

declare(strict_types=1);

namespace Cashbox\Core\Resources;

use Cashbox\Core\Data\Config\DriverData;
use Cashbox\Core\Enums\CurrencyEnum;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Model|\Cashbox\Core\Billable $payment
 */
abstract class Resource
{
    abstract public function currency(): CurrencyEnum;

    abstract public function sum(): int;

    public function __construct(
        public Model $payment,
        public DriverData $config
    ) {}

    public function paymentId(): string
    {
        return (string) $this->payment->getKey();
    }

    public function status(): mixed
    {
        return $this->payment->cashboxAttributeStatus();
    }
}
