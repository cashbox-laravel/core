<?php

/*
 * This file is part of the "cashier-provider/tinkoff-online" project.
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
 * @see https://github.com/cashier-provider/tinkoff-online
 */

namespace Tests\Fixtures\Resources;

use CashierProvider\Core\Resources\Model as BaseModel;
use Illuminate\Support\Carbon;

/** @property \Tests\Fixtures\Models\ReadyPayment $model */
class Model extends BaseModel
{
    public function getExternalId(): ?string
    {
        return $this->model->cashier->external_id ?? null;
    }

    protected function paymentId(): string
    {
        return $this->model->uuid;
    }

    protected function sum(): float
    {
        return $this->model->sum;
    }

    protected function currency(): int
    {
        return $this->model->currency;
    }

    protected function createdAt(): Carbon
    {
        return $this->model->created_at;
    }
}
