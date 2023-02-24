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

namespace CashierProvider\Core\Resources;

use CashierProvider\Core\Concerns\Relations;
use CashierProvider\Core\Facades\Helpers\Currency as CurrencyHelper;
use CashierProvider\Core\Facades\Helpers\Date;
use CashierProvider\Core\Facades\Helpers\Unique;
use DragonCode\Contracts\Cashier\Config\Driver;
use DragonCode\Contracts\Cashier\Resources\Model as Contract;
use DragonCode\Support\Concerns\Makeable;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Carbon;

abstract class Model implements Contract
{
    use Makeable;
    use Relations;

    protected EloquentModel $model;

    protected Driver $config;

    abstract protected function paymentId();

    abstract protected function sum();

    abstract protected function currency();

    abstract protected function createdAt(): Carbon;

    public function __construct(EloquentModel $model, Driver $config)
    {
        $this->model  = $model;
        $this->config = $config;
    }

    /**
     * @return \CashierProvider\Core\Concerns\Casheable|\Illuminate\Database\Eloquent\Model
     */
    public function getPaymentModel(): EloquentModel
    {
        return $this->model;
    }

    public function getClientId(): string
    {
        return $this->clientId();
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret();
    }

    public function getUniqueId(bool $every = false): string
    {
        return Unique::id($every);
    }

    public function getPaymentId(): string
    {
        return (string) $this->paymentId();
    }

    public function getSum(): int
    {
        $sum = (float) $this->sum();

        return (int) ($sum * 100);
    }

    public function getCurrency(): string
    {
        $currency = CurrencyHelper::get($this->currency());

        return (string) $currency->getNumeric();
    }

    public function getCreatedAt(): string
    {
        $date = $this->createdAt();

        return Date::toString($date);
    }

    public function getExternalId(): ?string
    {
        $this->resolveCashier($this->model);

        return $this->model->cashier->external_id ?? null;
    }

    public function getOperationId(): ?string
    {
        $this->resolveCashier($this->model);

        return $this->model->cashier->operation_id ?? null;
    }

    public function getConfig(): Driver
    {
        return $this->config;
    }

    public function getExtra(): ?array
    {
        return null;
    }

    protected function clientId(): string
    {
        return $this->config->getClientId();
    }

    protected function clientSecret(): string
    {
        return $this->config->getClientSecret();
    }
}
