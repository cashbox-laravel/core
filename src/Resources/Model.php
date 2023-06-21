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

use CashierProvider\Core\Data\Config\DriverData;
use CashierProvider\Core\Enums\Currency;
use CashierProvider\Core\Helpers\Date;
use DragonCode\Support\Concerns\Makeable;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Carbon;

abstract class Model
{
    use Makeable;

    abstract protected function createdAt(): Carbon;

    abstract protected function currency(): int|string;

    abstract protected function paymentId(): string;

    abstract protected function sum(): int;

    public function __construct(
        protected EloquentModel $model,
        protected DriverData $config,
        protected Date $date
    ) {}

    public function getPaymentModel(): EloquentModel
    {
        return $this->model;
    }

    public function clientId(): ?string
    {
        return $this->config->credentials?->clientId;
    }

    public function clientSecret(): string
    {
        return $this->config->credentials?->clientSecret;
    }

    public function getCurrency(): string
    {
        return (string) Currency::from($this->currency())->value;
    }

    public function getCreatedAt(): string
    {
        return $this->date->toString(
            $this->createdAt()
        );
    }

    public function getExternalId(): ?string
    {
        return $this->model->cashier?->external_id ?? null;
    }

    public function getOperationId(): ?string
    {
        return $this->model->cashier?->operation_id ?? null;
    }

    public function getExtra(): ?array
    {
        return null;
    }
}
