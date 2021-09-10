<?php

/*
 * This file is part of the "andrey-helldar/cashier" project.
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
 * @see https://github.com/andrey-helldar/cashier
 */

declare(strict_types=1);

namespace Helldar\Cashier\Resources;

use Helldar\Cashier\Concerns\Relations;
use Helldar\Cashier\Facades\Helpers\Currency as CurrencyHelper;
use Helldar\Cashier\Facades\Helpers\Date;
use Helldar\Cashier\Facades\Helpers\Unique;
use Helldar\Contracts\Cashier\Config\Driver;
use Helldar\Contracts\Cashier\Resources\Model as Contract;
use Helldar\Support\Concerns\Makeable;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Carbon;

abstract class Model implements Contract
{
    use Makeable;
    use Relations;

    protected $model;

    protected $config;

    public function __construct(EloquentModel $model, Driver $config)
    {
        $this->model  = $model;
        $this->config = $config;
    }

    /**
     * @return \Helldar\Cashier\Concerns\Casheable|\Illuminate\Database\Eloquent\Model
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

    public function getConfig(): Driver
    {
        return $this->config;
    }

    public function getExtra(): ?array
    {
        if (method_exists($this->model, 'cashierExtra')) {
            return $this->model->cashierExtra();
        }

        return null;
    }

    abstract protected function paymentId();

    abstract protected function sum();

    abstract protected function currency();

    abstract protected function createdAt(): Carbon;

    protected function clientId(): string
    {
        return $this->config->getClientId();
    }

    protected function clientSecret(): string
    {
        return $this->config->getClientSecret();
    }
}
