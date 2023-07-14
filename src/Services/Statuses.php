<?php

/**
 * This file is part of the "cashbox/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashbox-laravel/foundation
 */

declare(strict_types=1);

namespace Cashbox\Core\Services;

use Cashbox\Core\Concerns\Config\Payment\Attributes;
use Cashbox\Core\Concerns\Config\Payment\Payments;
use Cashbox\Core\Enums\StatusEnum;
use DragonCode\Support\Facades\Helpers\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class Statuses
{
    use Attributes;
    use Payments;

    public const FAILED    = [];
    public const NEW       = [];
    public const REFUNDED  = [];
    public const REFUNDING = [];
    public const SUCCESS   = [];

    public function __construct(
        protected Model $payment
    ) {}

    public function isUnknown(?StatusEnum $status = null): bool
    {
        $bank = array_merge([
            static::NEW,
            static::REFUNDING,
            static::REFUNDED,
            static::SUCCESS,
            static::FAILED,
        ]);

        return ! $this->hasCashbox($bank, $status)
            && ! $this->hasModel(StatusEnum::values(), $status);
    }

    public function isCreated(?StatusEnum $status = null): bool
    {
        return $this->hasCashbox(static::NEW, $status)
            || $this->hasModel(static::NEW, $status);
    }

    public function isFailed(?StatusEnum $status = null): bool
    {
        return $this->hasCashbox(static::FAILED, $status)
            || $this->hasModel(static::FAILED, $status);
    }

    public function isRefunding(?StatusEnum $status = null): bool
    {
        return $this->hasCashbox(static::REFUNDING, $status)
            || $this->hasModel(static::REFUNDING, $status);
    }

    public function isRefunded(?StatusEnum $status = null): bool
    {
        return $this->hasCashbox(static::REFUNDED, $status)
            || $this->hasModel(static::REFUNDED, $status);
    }

    public function isSuccess(?StatusEnum $status = null): bool
    {
        return $this->hasCashbox(static::SUCCESS, $status)
            || $this->hasModel(static::SUCCESS, $status);
    }

    public function inProgress(?StatusEnum $status = null): bool
    {
        return ! $this->isSuccess($status)
            && ! $this->isFailed($status)
            && ! $this->isRefunded($status);
    }

    protected function hasCashbox(array|string $statuses, ?StatusEnum $status): bool
    {
        $status ??= $this->cashboxStatus();

        return $this->has($status, $statuses);
    }

    protected function hasModel(array|string $statuses, StatusEnum $status): bool
    {
        $statuses = Arr::of((array) $statuses)
            ->map(fn (mixed $value) => static::payment()->status->fromEnum($status))
            ->toArray();

        return $this->has($status, $statuses);
    }

    protected function has(?StatusEnum $needle, array $haystack): bool
    {
        if (is_null($needle)) {
            return false;
        }

        return in_array($this->resolveStatus($needle), $this->resolveStatus($haystack), true);
    }

    protected function cashboxStatus(): ?StatusEnum
    {
        if ($status = $this->payment->cashbox?->details?->getStatus()) {
            return StatusEnum::tryFrom($status);
        }

        return null;
    }

    protected function modelStatus(): mixed
    {
        return $this->payment->getAttribute(
            static::attribute()->status
        );
    }

    protected function resolveStatus(mixed $status): mixed
    {
        if (is_array($status)) {
            return array_map(fn (mixed $value) => $this->resolveStatus($value), $status);
        }

        return is_string($status) ? Str::lower($status) : $status;
    }
}
