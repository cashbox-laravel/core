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

namespace CashierProvider\Core\Services;

use CashierProvider\Core\Concerns\Attributes;
use CashierProvider\Core\Facades\Config;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Database\Eloquent\Model;

/** @method static Statuses make(Model $model) */
abstract class Statuses
{
    use Attributes;
    use Makeable;

    public const FAILED = [];

    public const NEW = [];

    public const REFUNDED = [];

    public const REFUNDING = [];

    public const SUCCESS = [];

    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function hasUnknown(?string $status = null): bool
    {
        $bank = array_merge(
            static::NEW,
            static::REFUNDING,
            static::REFUNDED,
            static::FAILED,
            static::SUCCESS,
        );

        $model = [
            StatusType::new,
            StatusType::waitRefund,
            StatusType::refund,
            StatusType::failed,
            StatusType::success,
        ];

        return ! $this->hasCashier($bank, $status)
            && ! $this->hasModel($model, $status);
    }

    public function hasCreated(?string $status = null): bool
    {
        return $this->hasCashier(static::NEW, $status)
            || $this->hasModel([StatusType::new], $status);
    }

    public function hasFailed(?string $status = null): bool
    {
        return $this->hasCashier(static::FAILED, $status)
            || $this->hasModel([StatusType::failed], $status);
    }

    public function hasRefunding(?string $status = null): bool
    {
        return $this->hasCashier(static::REFUNDING, $status)
            || $this->hasModel([StatusType::waitRefund], $status);
    }

    public function hasRefunded(?string $status = null): bool
    {
        return $this->hasCashier(static::REFUNDED, $status)
            || $this->hasModel([StatusType::refund], $status);
    }

    public function hasSuccess(?string $status = null): bool
    {
        return $this->hasCashier(static::SUCCESS, $status)
            || $this->hasModel([StatusType::success], $status);
    }

    public function inProgress(?string $status = null): bool
    {
        return ! $this->hasSuccess($status)
            && ! $this->hasFailed($status)
            && ! $this->hasRefunded($status);
    }

    /**
     * @param array<string> $statuses
     * @param string|null $status
     *
     * @return bool
     */
    protected function hasCashier(array $statuses, ?string $status): bool
    {
        $status = ! is_null($status) ? $status : $this->resolveCashierStatus();

        return $this->has($statuses, $status);
    }

    /**
     * @param array<StatusType> $statuses
     * @param $status
     *
     * @return bool
     */
    protected function hasModel(array $statuses, $status = null): bool
    {
        $statuses = Arr::map($statuses, static fn (StatusType $type) => Config::payment()->status->get($type));

        $status = $status ?: $this->modelStatus();

        return $this->has($statuses, $status);
    }

    protected function has(array $statuses, $status = null): bool
    {
        return ! is_null($status) && in_array($this->resolveStatus($status), $this->resolveStatus($statuses), true);
    }

    protected function resolveCashierStatus(): ?string
    {
        return $this->model?->cashier?->details?->status ?? null;
    }

    protected function modelStatus()
    {
        return $this->model->getAttribute(
            $this->attributeStatus()
        );
    }

    protected function resolveStatus(array|string $status): array|string
    {
        if (is_array($status)) {
            return array_map(fn (array|string $value) => $this->resolveStatus($value), $status);
        }

        return Str::upper($status);
    }
}
