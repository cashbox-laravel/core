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

use CashierProvider\Core\Concerns\Attributes;
use CashierProvider\Core\Enums\Status;
use CashierProvider\Core\Facades\Config;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Helpers\Arr;
use Illuminate\Database\Eloquent\Model;

/** @method static Statuses make(Model $model) */
abstract class Statuses
{
    use Attributes;
    use Makeable;

    public const FAILED    = [];
    public const NEW       = [];
    public const REFUNDED  = [];
    public const REFUNDING = [];
    public const SUCCESS   = [];

    public function __construct(
        protected Model $model
    ) {}

    public function hasUnknown(mixed $status = null): bool
    {
        $bank = array_merge(
            static::NEW,
            static::REFUNDING,
            static::REFUNDED,
            static::FAILED,
            static::SUCCESS,
        );

        $model = [
            Status::new,
            Status::waitRefund,
            Status::refund,
            Status::failed,
            Status::success,
        ];

        return ! $this->hasCashier($bank, $status)
            && ! $this->hasModel($model, $status);
    }

    public function hasCreated(mixed $status = null): bool
    {
        return $this->hasCashier(static::NEW, $status)
            || $this->hasModel([Status::new], $status);
    }

    public function hasFailed(mixed $status = null): bool
    {
        return $this->hasCashier(static::FAILED, $status)
            || $this->hasModel([Status::failed], $status);
    }

    public function hasRefunding(mixed $status = null): bool
    {
        return $this->hasCashier(static::REFUNDING, $status)
            || $this->hasModel([Status::waitRefund], $status);
    }

    public function hasRefunded(mixed $status = null): bool
    {
        return $this->hasCashier(static::REFUNDED, $status)
            || $this->hasModel([Status::refund], $status);
    }

    public function hasSuccess(mixed $status = null): bool
    {
        return $this->hasCashier(static::SUCCESS, $status)
            || $this->hasModel([Status::success], $status);
    }

    public function inProgress(mixed $status = null): bool
    {
        return ! $this->hasSuccess($status)
            && ! $this->hasFailed($status)
            && ! $this->hasRefunded($status);
    }

    protected function hasCashier(array $statuses, mixed $status): bool
    {
        $status = $status ?: $this->resolveCashierStatus();

        return $this->has($statuses, $status);
    }

    /**
     * @param  array<Status>  $statuses
     */
    protected function hasModel(array $statuses, mixed $status): bool
    {
        $statuses = Arr::map($statuses, static fn (Status $type) => Config::payment()->status->get($type));

        $status = $status ?: $this->modelStatus();

        return $this->has($statuses, $status);
    }

    protected function has(array $statuses, mixed $status): bool
    {
        return ! is_null($status) && in_array($status, $statuses, true);
    }

    protected function resolveCashierStatus(): ?string
    {
        return $this->model?->cashier?->details?->status ?? null;
    }

    protected function modelStatus(): mixed
    {
        return $this->model->cashierStatus();
    }
}
