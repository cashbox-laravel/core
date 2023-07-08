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

namespace CashierProvider\Core\Data\Config\Payment;

use CashierProvider\Core\Enums\StatusEnum;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class StatusData extends Data
{
    public mixed $new;

    public mixed $success;

    public mixed $refund;

    public mixed $waitRefund;

    public mixed $failed;

    public function fromEnum(StatusEnum $status): mixed
    {
        return match ($status) {
            StatusEnum::new        => $this->new,
            StatusEnum::success    => $this->success,
            StatusEnum::refund     => $this->refund,
            StatusEnum::waitRefund => $this->waitRefund,
            StatusEnum::failed     => $this->failed,
        };
    }

    public function toEnum(int|string $status): StatusEnum
    {
        return match ($status) {
            $this->new        => StatusEnum::new,
            $this->success    => StatusEnum::success,
            $this->refund     => StatusEnum::refund,
            $this->waitRefund => StatusEnum::waitRefund,
            $this->failed     => StatusEnum::failed,
        };
    }

    public function inProgress(): array
    {
        return [
            $this->new,
            $this->waitRefund,
        ];
    }

    public function toRefund(): array
    {
        return [
            $this->new,
            $this->success,
        ];
    }
}
