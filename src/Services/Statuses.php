<?php

/**
 * This file is part of the "cashier-provider/core" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider
 */

declare(strict_types=1);

namespace CashierProvider\Core\Services;

use CashierProvider\Core\Concerns\Relations;
use CashierProvider\Core\Constants\Status;
use CashierProvider\Core\Facades\Config\Payment;
use DragonCode\Contracts\Cashier\Helpers\Statuses as Contract;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Database\Eloquent\Model;

/** @method static Statuses make(Model $model) */
abstract class Statuses implements Contract
{
    use Makeable;

    use Relations;

    public const NEW = [];

    public const REFUNDING = [];

    public const REFUNDED = [];

    public const FAILED = [];

    public const SUCCESS = [];

    /** @var \CashierProvider\Core\Concerns\Casheable|\Illuminate\Database\Eloquent\Model */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function hasUnknown($status = null): bool
    {
        $bank = array_merge([
            static::NEW,
            static::REFUNDING,
            static::REFUNDED,
            static::FAILED,
            static::SUCCESS,
        ]);

        $model = [
            Status::NEW,
            Status::WAIT_REFUND,
            Status::REFUND,
            Status::FAILED,
            Status::SUCCESS,
        ];

        return ! $this->hasCashier($bank, $status)
               && ! $this->hasModel($model, $status);
    }

    public function hasCreated($status = null): bool
    {
        return $this->hasCashier(static::NEW, $status)
               || $this->hasModel([Status::NEW], $status);
    }

    public function hasFailed($status = null): bool
    {
        return $this->hasCashier(static::FAILED, $status)
               || $this->hasModel([Status::FAILED], $status);
    }

    public function hasRefunding($status = null): bool
    {
        return $this->hasCashier(static::REFUNDING, $status)
               || $this->hasModel([Status::WAIT_REFUND], $status);
    }

    public function hasRefunded($status = null): bool
    {
        return $this->hasCashier(static::REFUNDED, $status)
               || $this->hasModel([Status::REFUND], $status);
    }

    public function hasSuccess($status = null): bool
    {
        return $this->hasCashier(static::SUCCESS, $status)
               || $this->hasModel([Status::SUCCESS], $status);
    }

    public function inProgress($status = null): bool
    {
        return ! $this->hasSuccess($status)
               && ! $this->hasFailed($status)
               && ! $this->hasRefunded($status);
    }

    protected function hasCashier(array $statuses, $status = null): bool
    {
        $status = ! is_null($status) ? $status : $this->cashierStatus();

        return $this->has($statuses, $status);
    }

    protected function hasModel(array $statuses, $status = null): bool
    {
        $statuses = Arr::map($statuses, static function (string $status) {
            return Payment::getStatuses()->getStatus($status);
        });

        $status = ! is_null($status) ? $status : $this->modelStatus();

        return $this->has($statuses, $status);
    }

    protected function has(array $statuses, $status = null): bool
    {
        return ! is_null($status) && in_array($this->resolveStatus($status), $this->resolveStatus($statuses), true);
    }

    protected function cashierStatus(): ?string
    {
        $this->resolveCashier($this->model);

        if ($this->model->cashier && $this->model->cashier->details) {
            return $this->model->cashier->details->getStatus();
        }

        return null;
    }

    protected function modelStatus()
    {
        $field = Payment::getAttributes()->getStatus();

        return $this->model->getAttribute($field);
    }

    /**
     * @param array|string $status
     *
     * @return array|string
     */
    protected function resolveStatus($status)
    {
        if (is_array($status)) {
            return array_map(function ($value) {
                return $this->resolveStatus($value);
            }, $status);
        }

        return Str::upper($status);
    }
}
