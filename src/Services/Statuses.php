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
 * @see https://cashbox.city
 */

declare(strict_types=1);

namespace Cashbox\Core\Services;

use Cashbox\Core\Concerns\Config\Payment\Payments;
use Cashbox\Core\Enums\StatusEnum;
use DragonCode\Support\Facades\Helpers\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property Model|\Cashbox\Core\Billable $payment
 */
abstract class Statuses
{
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

    public function detect(string $status): ?StatusEnum
    {
        return match (true) {
            $this->contains($status, static::NEW)       => StatusEnum::New,
            $this->contains($status, static::SUCCESS)   => StatusEnum::Success,
            $this->contains($status, static::REFUNDING) => StatusEnum::WaitRefund,
            $this->contains($status, static::REFUNDED)  => StatusEnum::Refund,
            $this->contains($status, static::FAILED)    => StatusEnum::Failed,
            default                                     => null
        };
    }

    protected function hasCashbox(array $statuses, ?StatusEnum $status): bool
    {
        $status ??= $this->payment->cashbox?->status;

        return $this->has($status, $statuses);
    }

    protected function hasModel(array|string $statuses, StatusEnum $status): bool
    {
        $statuses = Arr::of((array) $statuses)
            ->map(fn (mixed $value) => static::paymentConfig()->status->fromEnum($status))
            ->toArray();

        return $this->has($status, $statuses);
    }

    protected function has(?StatusEnum $needle, array $haystack): bool
    {
        if (is_null($needle)) {
            return false;
        }

        return in_array($needle, $this->resolveStatuses($haystack), true);
    }

    protected function resolveStatuses(mixed $statuses): array
    {
        return array_map(fn (string $status) => $this->detect($status), $statuses);
    }

    protected function contains(string $haystack, array $needles): bool
    {
        return Str::contains($haystack, $needles, true);
    }
}
